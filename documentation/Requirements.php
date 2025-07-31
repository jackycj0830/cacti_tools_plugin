<?php
/**
 * Cacti Requirements Page
 * 
 * This page displays the system requirements for Cacti installation
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_requirements', 'requirements', true);
?>

<h1 id="requirements"><?php _e('requirements'); ?></h1>

<p><?php _e('requirements_intro', 'Cacti requires that the following software is installed on your system.'); ?></p>

<ul>
<li><p><?php _e('web_server_req', 'Web Server that supports PHP e.g. Apache, Nginx, or IIS'); ?></p></li>
<li><p><?php _e('build_env_req', 'Build environment when using spine (gcc, automake, autoconf, libtool, help2man)'); ?></p></li>
<li><p><?php _e('rrdtool_req', 'RRDtool 1.3 or greater, 1.5+ recommended'); ?></p></li>
<li><p><?php _e('php_req', 'PHP 5.4 or greater, 5.5+ recommended'); ?></p></li>
</ul>

<h2 id="required-php-modules"><?php _e('required_modules', 'Required modules:'); ?></h2>

<ul>
<li>session</li>
<li>sockets</li>
<li>PDO</li>
<li>xml</li>
<li>ldap</li>
<li>mbstring</li>
<li>pcre</li>
<li>json</li>
<li>openssl</li>
<li>gd</li>
<li>zlib</li>
</ul>

<h2 id="optional-php-modules"><?php _e('optional_modules', 'Optional modules:'); ?></h2>

<ul>
<li>snmp</li>
<li>gmp (for advanced calculations)</li>
<li>com_dotnet (for Windows)</li>
</ul>

<h2 id="mysql-requirements"><?php _e('mysql_req', 'MySQL 5.6 or MariaDB 5.5 or greater'); ?></h2>

<p><?php _e('timezone_support', 'Timezone support must be enabled'); ?></p>

<h3 id="mysql-configuration"><?php _e('mycnf_recommendations', 'The following are my.cnf recommendations:'); ?></h3>

<pre><code>[mysqld]
max_heap_table_size = 128M
max_allowed_packet = 16777216
tmp_table_size = 64M
join_buffer_size = 64M
innodb_file_per_table = on
innodb_buffer_pool_size = 512M
innodb_doublewrite = off
innodb_lock_wait_timeout = 50
innodb_flush_log_at_trx_commit = 2
innodb_file_format = Barracuda
</code></pre>

<h2 id="problematic-software"><?php _e('problematic_software', 'Problematic software and configuration'); ?></h2>

<ul>
<li><strong>Windows Defender</strong> - May interfere with Cacti operations</li>
<li><strong>SELinux</strong> - May require additional configuration</li>
<li><strong>Firewall</strong> - Ensure proper ports are open</li>
<li><strong>Antivirus</strong> - May block Cacti processes</li>
</ul>

<h2 id="browser-requirements"><?php _e('browser_requirements', 'Browser Requirements'); ?></h2>

<p><?php _e('browser_requirements_desc', 'Cacti has been tested to work on the following browsers:'); ?></p>

<ul>
<li>Internet Explorer 9+</li>
<li>Firefox 3+</li>
<li>Chrome 14+</li>
<li>Safari 4+</li>
<li>Opera 9+</li>
</ul>

<h2 id="network-requirements"><?php _e('network_requirements', 'Network Requirements'); ?></h2>

<ul>
<li><strong>SNMP</strong> - For device monitoring</li>
<li><strong>HTTP/HTTPS</strong> - For web interface access</li>
<li><strong>SSH</strong> - For secure device access (optional)</li>
<li><strong>Telnet</strong> - For device access (not recommended)</li>
</ul>

<h2 id="performance-considerations"><?php _e('performance_considerations', 'Performance Considerations'); ?></h2>

<p><?php _e('performance_desc', 'The following factors affect Cacti performance:'); ?></p>

<ul>
<li><strong><?php _e('cpu_requirements', 'CPU'); ?></strong> - <?php _e('cpu_desc', 'Multi-core processors recommended for large installations'); ?></li>
<li><strong><?php _e('memory_requirements', 'Memory'); ?></strong> - <?php _e('memory_desc', 'Minimum 1GB RAM, 4GB+ recommended for large installations'); ?></li>
<li><strong><?php _e('storage_requirements', 'Storage'); ?></strong> - <?php _e('storage_desc', 'Fast storage (SSD) recommended for RRD files'); ?></li>
<li><strong><?php _e('network_bandwidth', 'Network'); ?></strong> - <?php _e('network_desc', 'Sufficient bandwidth for SNMP polling'); ?></li>
</ul>

<h2 id="security-considerations"><?php _e('security_considerations', 'Security Considerations'); ?></h2>

<ul>
<li><?php _e('security_ssl', 'Use SSL/TLS for web interface access'); ?></li>
<li><?php _e('security_passwords', 'Use strong passwords for all accounts'); ?></li>
<li><?php _e('security_updates', 'Keep all software components updated'); ?></li>
<li><?php _e('security_firewall', 'Configure firewall to restrict access'); ?></li>
<li><?php _e('security_snmp', 'Use SNMPv3 when possible for device monitoring'); ?></li>
</ul>

<?php
// Generate page footer
generatePageFooter();
?>
