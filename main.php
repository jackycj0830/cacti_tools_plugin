<?php
/*
 +-------------------------------------------------------------------------+
 | Copyright (C) 2004-2023 The Cacti Group                                 |
 |                                                                         |
 | This program is free software; you can redistribute it and/or           |
 | modify it under the terms of the GNU General Public License             |
 | as published by the Free Software Foundation; either version 2          |
 | of the License, or (at your option) any later version.                  |
 |                                                                         |
 | This program is distributed in the hope that it will be useful,         |
 | but WITHOUT ANY WARRANTY; without even the implied warranty of          |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           |
 | GNU General Public License for more details.                            |
 +-------------------------------------------------------------------------+
 | Cacti: The Complete RRDTool-based Graphing Solution                     |
 +-------------------------------------------------------------------------+
 | This code is designed, written, and maintained by the Cacti Group. See  |
 | about.php and/or the AUTHORS file for specific developer information.   |
 +-------------------------------------------------------------------------+
 | http://www.cacti.net/                                                   |
 +-------------------------------------------------------------------------+
 | Customized PHP Pages (By Jacky.zou editor)  v.1.0.4_20250802            |
 +-------------------------------------------------------------------------+
*/
?>
<!-- 標題按鈕區 -->
<table name="header" id="header" width="100%" border="0" style="table-layout:fixed" class="fixed">
    <tbody>
        <tr>
            <td align="left" valign="center" width="98.5%">
                <button class="button-spacing" onclick="showFrame('frameHome')">
                    <font face="Verdana" size="1" color="#757575"> Home </font>
                </button>
                <button class="button-spacing" onclick="showFrame('frameStatus')">
                    <font face="Verdana" size="1" color="#757575"> Status </font>
                </button>
                <button class="button-spacing" onclick="showFrame('frameSharepoint')">
                    <font face="Verdana" size="1" color="#757575"> Sharepoint </font>
                </button>
                <button class="button-spacing" onclick="showFrame('frameGraphs')">
                    <font face="Verdana" size="1" color="#757575"> Graphs </font>
                </button>
                <button class="button-spacing" onclick="showFrame('frameRrdviewer')">
                    <font face="Verdana" size="1" color="#757575"> RRD Viewer </font>
                </button>
                <button class="button-spacing" onclick="showFrame('frameDocuments')">
                    <font face="Verdana" size="1" color="#757575"> Documents </font>
                </button>
                <button class="button-spacing" onclick="showFrame('frameDocumentation')">
                    <font face="Verdana" size="1" color="#757575"> Documentation </font>
                </button>
                <button class="button-spacing" onclick="showFrame('frameManageTholdCacti')">
                    <font face="Verdana" size="1" color="#757575"> Manage </font>
                </button>
                <button class="button-spacing" onclick="showFrame('frameUpdater')">
                    <font face="Verdana" size="1" color="#757575"> Updater </font>
                </button>
            </td>
        </tr>
    </tbody>
</table>

<!-- 內容切換的 frame 區（已移除 frameSharepoint）-->
<iframe id="frameHome" class="frame" src="/cacti/plugins/tools/home.php" sandbox="allow-scripts allow-same-origin"></iframe>
<iframe id="frameStatus" class="frame" src="/cacti/plugins/tools/status.php" sandbox="allow-scripts allow-same-origin"></iframe>
<!-- <iframe id="frameSharepoint" class="frame" src="" sandbox="allow-scripts allow-same-origin"></iframe>  這行可刪除 -->
<iframe id="frameGraphs" class="frame" src="/cacti/plugins/tools/graph_view.php" sandbox="allow-scripts allow-same-origin"></iframe>
<iframe id="frameRrdviewer" class="frame" src="/cacti/plugins/tools/rrd_graph_viewer_daily.php" sandbox="allow-scripts allow-same-origin"></iframe>
<iframe id="frameDocuments" class="frame" src="/cacti/plugins/tools/documents.php" sandbox="allow-scripts allow-same-origin"></iframe>
<iframe id="frameDocumentation" class="frame" src="/cacti/plugins/tools/documentation/documentation.php" sandbox="allow-scripts allow-same-origin"></iframe>
<iframe id="frameManageTholdCacti" class="frame" src="/cacti/plugins/tools/manage_thold_cacti.php" sandbox="allow-scripts allow-same-origin"></iframe>
<iframe id="frameUpdater" class="frame" src="/cacti/plugins/tools/updater.php" sandbox="allow-scripts allow-same-origin"></iframe>

<!-- CSS 直接寫在 style 標籤，嵌入式最安全 -->
<style>
    .frame { display: none; width: 100%; height: 650px; border: 0px solid #000; margin-top: 0px; }
    #frameHome { display: block; }
    #frameStatus, #frameGraphs , #frameRrdviewer, #frameDocuments, #frameDocumentation, #frameManageTholdCacti, #frameUpdater { display: none; }
    .button-spacing { margin-right: 2.5px; }
</style>

<!-- JavaScript 切換邏輯 -->
<script>
    function showFrame(frameId) {
        // 特別處理 Sharepoint，開新視窗並結束
        if (frameId === 'frameSharepoint') {
            window.open('https://tpvtech3.sharepoint.com/sites/CactiUpgrade328/', '_blank');
            return;
        }
        // 其餘 frame 按照原本的顯示邏輯
        var frames = document.getElementsByClassName('frame');
        for (var i = 0; i < frames.length; i++) {
            frames[i].style.display = 'none';
        }
        document.getElementById(frameId).style.display = 'block';
    }
</script>