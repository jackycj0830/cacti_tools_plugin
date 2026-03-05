param(
    [string]$UsernamesList = "",
    [string]$UsernamesFile = ""
)

$ErrorActionPreference = "SilentlyContinue"

Function Convert-ADFileTime {
    param([System.Object]$Ticks)
    if ($null -eq $Ticks -or $Ticks -eq 0 -or $Ticks -eq 9223372036854775807) { return "N/A" }
    try {
        if ($Ticks.GetType().Name -eq "__ComObject") {
            # Sometimes ADSI returns ComObject for LargeInteger
            $HighPart = [int]$Ticks.GetType().InvokeMember("HighPart", [System.Reflection.BindingFlags]::GetProperty, $null, $Ticks, $null)
            $LowPart = [int]$Ticks.GetType().InvokeMember("LowPart", [System.Reflection.BindingFlags]::GetProperty, $null, $Ticks, $null)
            $T = ([long]$HighPart -shl 32) + $LowPart
            if ($T -eq 0) { return "N/A" }
            return [datetime]::FromFileTimeUtc($T).ToLocalTime().ToString("yyyy-MM-dd HH:mm:ss")
        }
        else {
            return [datetime]::FromFileTimeUtc([long]$Ticks).ToLocalTime().ToString("yyyy-MM-dd HH:mm:ss")
        }
    }
    catch {
        return "N/A"
    }
}

$usernames = @()
if (-not [string]::IsNullOrWhiteSpace($UsernamesList)) {
    $usernames = $UsernamesList -split ','
}
elseif (-not [string]::IsNullOrWhiteSpace($UsernamesFile)) {
    if (Test-Path $UsernamesFile) {
        $usernames = Get-Content $UsernamesFile
    }
}

$cleanUsernames = @()
foreach ($u in $usernames) { if (![string]::IsNullOrWhiteSpace($u)) { $cleanUsernames += $u } }
$cleanUsernames = $cleanUsernames | Select-Object -Unique

$results = @()
if ($cleanUsernames.Count -eq 0) {
    @() | ConvertTo-Json -Compress
    exit
}

$filter = "(|"
foreach ($u in $cleanUsernames) {
    $filter += "(sAMAccountName=$u)"
}
$filter += ")"

$searcher = [adsisearcher]"(&(objectCategory=person)(objectClass=user)$filter)"
$searcher.PropertiesToLoad.Add("samaccountname") > $null
$searcher.PropertiesToLoad.Add("useraccountcontrol") > $null
$searcher.PropertiesToLoad.Add("lockouttime") > $null
$searcher.PropertiesToLoad.Add("pwdlastset") > $null
$searcher.PropertiesToLoad.Add("lastlogontimestamp") > $null
$searcher.PropertiesToLoad.Add("accountexpires") > $null
$searcher.PropertiesToLoad.Add("department") > $null
$searcher.PropertiesToLoad.Add("physicaldeliveryofficename") > $null
$searcher.PropertiesToLoad.Add("telephonenumber") > $null
$searcher.PropertiesToLoad.Add("distinguishedname") > $null
$searcher.PageSize = 1000

$adResults = $searcher.FindAll()

$resultsMap = @{}

foreach ($result in $adResults) {
    $sam = "Unknown"
    if ($result.Properties["samaccountname"] -and $result.Properties["samaccountname"].Count -gt 0) {
        $sam = $result.Properties["samaccountname"][0]
    }
    
    # Check lockout
    $lockoutTimeVal = $result.Properties["lockouttime"]
    $isLocked = $false
    $lockoutTimeStr = "N/A"
    if ($lockoutTimeVal -and $lockoutTimeVal.Count -gt 0) {
        $lt = $lockoutTimeVal[0]
        if ($lt.GetType().Name -eq "__ComObject") {
            $HighPart = [int]$lt.GetType().InvokeMember("HighPart", [System.Reflection.BindingFlags]::GetProperty, $null, $lt, $null)
            $LowPart = [int]$lt.GetType().InvokeMember("LowPart", [System.Reflection.BindingFlags]::GetProperty, $null, $lt, $null)
            $T = ([long]$HighPart -shl 32) + $LowPart
            $isLocked = ($T -gt 0)
            if ($isLocked) { $lockoutTimeStr = Convert-ADFileTime -Ticks $lt }
        }
        else {
            $isLocked = ([long]$lt -gt 0)
            if ($isLocked) { $lockoutTimeStr = Convert-ADFileTime -Ticks $lt }
        }
    }
    
    # Check password expired natively and fetch last set time
    $pwdLastSetVal = $result.Properties["pwdlastset"]
    $pwdExpired = $false
    $pwdLastSetTime = "N/A"
    if ($pwdLastSetVal -and $pwdLastSetVal.Count -gt 0) {
        $pls = $pwdLastSetVal[0]
        if ($pls.GetType().Name -eq "__ComObject") {
            $HighPart = [int]$pls.GetType().InvokeMember("HighPart", [System.Reflection.BindingFlags]::GetProperty, $null, $pls, $null)
            $LowPart = [int]$pls.GetType().InvokeMember("LowPart", [System.Reflection.BindingFlags]::GetProperty, $null, $pls, $null)
            $T = ([long]$HighPart -shl 32) + $LowPart
            $pwdExpired = ($T -eq 0)
            if ($T -gt 0) {
                $pwdLastSetTime = Convert-ADFileTime -Ticks $pls
            }
        }
        else {
            $pwdExpired = ([long]$pls -eq 0)
            if ([long]$pls -gt 0) {
                $pwdLastSetTime = Convert-ADFileTime -Ticks $pls
            }
        }
    }
    
    $dept = "N/A"
    if ($result.Properties["department"] -and $result.Properties["department"].Count -gt 0) {
        $dept = $result.Properties["department"][0]
    }
    $site = "N/A"
    if ($result.Properties["physicaldeliveryofficename"] -and $result.Properties["physicaldeliveryofficename"].Count -gt 0) {
        $site = $result.Properties["physicaldeliveryofficename"][0]
    }
    
    # If Site is a number or N/A, try to extract OU hierarchy from distinguishedname
    if ($site -eq "N/A" -or $site -match '^\d+$') {
        if ($result.Properties["distinguishedname"] -and $result.Properties["distinguishedname"].Count -gt 0) {
            $dn = $result.Properties["distinguishedname"][0]
            $ouMatches = [regex]::Matches($dn, "OU=([^,]+)")
            if ($ouMatches.Count -gt 0) {
                $ouList = @()
                foreach ($m in $ouMatches) {
                    $ouList += $m.Groups[1].Value
                }
                [array]::Reverse($ouList)
                $site = $ouList -join ' > '
            }
        }
    }

    $phone = "N/A"
    if ($result.Properties["telephonenumber"] -and $result.Properties["telephonenumber"].Count -gt 0) {
        $phone = $result.Properties["telephonenumber"][0]
    }
    
    $lastLogon = "N/A"
    if ($result.Properties["lastlogontimestamp"] -and $result.Properties["lastlogontimestamp"].Count -gt 0) {
        $lastLogon = Convert-ADFileTime $result.Properties["lastlogontimestamp"][0]
    }
    
    $resultsMap[$sam.ToLower()] = @{
        Exists          = $true
        LockedOut       = $isLocked
        LockoutTime     = $lockoutTimeStr
        PasswordExpired = $pwdExpired
        PwdLastSet      = $pwdLastSetTime
        LastLogon       = $lastLogon
        Department      = $dept
        AdSite          = $site
        OfficePhone     = $phone
    }
}

foreach ($u in $cleanUsernames) {
    $mapKey = $u.ToLower()
    if ($resultsMap.ContainsKey($mapKey)) {
        $data = $resultsMap[$mapKey]
        $results += @{
            Username        = $u
            Exists          = $data.Exists
            LockedOut       = $data.LockedOut
            LockoutTime     = $data.LockoutTime
            PasswordExpired = $data.PasswordExpired
            PwdLastSet      = $data.PwdLastSet
            LastLogon       = $data.LastLogon
            Department      = $data.Department
            AdSite          = $data.AdSite
            OfficePhone     = $data.OfficePhone
        }
    }
    else {
        $results += @{
            Username        = $u
            Exists          = $false
            LockedOut       = "N/A"
            LockoutTime     = "N/A"
            PasswordExpired = "N/A"
            PwdLastSet      = "N/A"
            LastLogon       = "N/A"
            Department      = "N/A"
            AdSite          = "N/A"
            OfficePhone     = "N/A"
        }
    }
}

$results | ConvertTo-Json -Depth 3 -Compress
