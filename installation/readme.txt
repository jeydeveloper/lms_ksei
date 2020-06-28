btn
max 50m



xampplite 1.7.1
	Apache HTTPD 2.2.11 + Openssl 0.9.8i
	MySQL 5.1.33
	PHP 5.2.9
	phpMyAdmin 3.1.3.1
	XAMPP CLI Bundle 1.3
	FileZilla FTP Server 0.9.31
	Mercury Mail Transport System 4.62

SYSTEM SETUP
============
- install xampp
- copy Config.php ke ./xampp/php/pear/
- edit php.ini : 	 
         set register global Off
         set session auto start off
         error_log = <set-to-your-path>   ; ex "C:/phperr.txt"
         log_errors = On 
         memory_limit = 256M
         enable untuk mysql  extension
         include_path = ".;C:\xampp\php\pear\"  ; arahkan ke folder pear
         allow_call_time_pass_reference = On
   edit path : //xampp ==> physical path 


APPLICATION SETUP                  
=================
- edit system/application/config/config.php 
	$config['base_url']	= "http://localhost/lmsv2/";  //sesuaikan dengan environtment
	$config['theme'] 	= "brp";
	$config['company'] 	= "Bank Resona Perdania";
	$config['uri_protocol']	= "AUTO";
	$config['enable_query_strings'] = TRUE;

- edit database config : ./system/application/config/database.php
   	$db['default']['hostname'] = "localhost";
	$db['default']['username'] = "root";
	$db['default']['password'] = "abcd";
	$db['default']['database'] = "netpolitan_lmsv2";
	$db['default']['dbdriver'] = "mysql";

- update mysql password : 
UPDATE mysql.user SET Password=PASSWORD('newpass')
  WHERE User='xxx' AND Host='xxx';
FLUSH PRIVILEGES;

create user database :
CREATE USER 'user'@'localhost' IDENTIFIED BY 'user123456';
GRANT INSERT,UPDATE,DELETE,SELECT on netpolitan_lms.* to user@localhost;
FLUSH PRIVILEGES;

samples :
CREATE USER 'monty'@'localhost' IDENTIFIED BY 'some_pass';
GRANT ALL PRIVILEGES ON *.* TO 'monty'@'localhost' WITH GRANT OPTION;

CREATE USER 'monty'@'%' IDENTIFIED BY 'some_pass';
GRANT ALL PRIVILEGES ON *.* TO 'monty'@'%' WITH GRANT OPTION;

ALTER TABLE tbl AUTO_INCREMENT = 100;

-edit system/application/config/config.path.php 
	$config['mysqldumpshell'] = "c:\\xampp\\mysql\\bin\\mysqldump";
	$config['mysqlimportshell'] = "c:\\xampp\\mysql\\bin\\mysql";
	$config['base_path']		= "C:/xampp/htdocs/elearning";
-

- scheduling
hirarki			=> c:\xampp\php\php.exe G:\lmsv2\index.php import saveorg <import_filename>
hirarki group 	=> c:\xampp\php\php.exe G:\lmsv2\index.php import savegroup <import_filename>
jabatan 		=> c:\xampp\php\php.exe G:\lmsv2\index.php import savejabatan <import_filename>
lokasi 			=> c:\xampp\php\php.exe G:\lmsv2\index.php import savelokasi <import_filename>
category/topic 	=> c:\xampp\php\php.exe G:\lmsv2\index.php import savecategory <import_filename>
training 		=> c:\xampp\php\php.exe G:\lmsv2\index.php import savetraining <import_filename>
history exam 	=> c:\xampp\php\php.exe G:\lmsv2\index.php import savehistoryexam <import_filename>
user 			=> c:\xampp\php\php.exe G:\lmsv2\index.php user saveimport <import_filename>	

contoh scheduling : 
C:\xampp\php\php.exe E:\lmsv2\index.php import saveorg E:\lmsv2\inbox\hierarchy.xls
C:\xampp\php\php.exe E:\lmsv2\index.php import savegroup E:\lmsv2\inbox\hierarchy_group.xls
C:\xampp\php\php.exe E:\lmsv2\index.php import savejabatan E:\lmsv2\inbox\hierarchy.xls
C:\xampp\php\php.exe E:\lmsv2\index.php import savelokasi E:\lmsv2\inbox\hierarchy.xls
C:\xampp\php\php.exe E:\lmsv2\index.php import savecategory E:\lmsv2\inbox\category_topic.xls
C:\xampp\php\php.exe E:\lmsv2\index.php import savetraining E:\lmsv2\inbox\training.xls
C:\xampp\php\php.exe E:\lmsv2\index.php import savehistoryexam E:\lmsv2\inbox\history_exam.xls
C:\xampp\php\php.exe E:\lmsv2\index.php import saveimport E:\lmsv2\inbox\Userv2.xls

options : <fileimport> <0|1>

1=file direname, menjadi <nama_file>_tanggal
0=default, tidak direname
	
sesuaikan dengan environtment

- refreshment scheduling
c:\xampp\php\php.exe E:\lmsv2\index.php training refreshment
Scheduling akan menambah sendiri period jika sudah expired dan refreshment > 0
Misal training A: 20090426 - 20090430 maka akan otomatis dibuat periode 20100426 - 20100430

export history (to SAP)
c:\xampp\php\php.exe  g:\lmsv2\index.php training exporthistory 1
c:\xampp\php\php.exe  E:\dedy\kerjaan\netpolitan\lms2\trunk\index.php training exporthistory 1
c:\xampp\php\php.exe  E:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php training exporthistory 1 csv ==> for csv format

import employee (From SAP)
"c:\Program Files\xampp\php\php.exe" E:\dedy\kerjaan\netpolitan\lms2\trunk\index.php user sap
c:\xampp\php\php.exe E:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php user sap
 php H:\lmsv2\index.php user sap -> untuk csv (default)
 php H:\lmsv2\index.php user sap xsl -> untuk xls

migrasi : 
index.php migrasi exam 1 ==> lgs insert


export report to sap :
index.php sapbankwide
index.php sapbygroup
index.php sapbydept
index.php sapbyunit
index.php sapcoursecode
index.php sapbydir
c:\xampp\php\php.exe  E:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php sapbankwide
c:\xampp\php\php.exe  E:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php sapbydir
c:\xampp\php\php.exe  E:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php sapbygroup
c:\xampp\php\php.exe  E:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php sapbydept
c:\xampp\php\php.exe  E:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php sapbyunit
c:\xampp\php\php.exe  E:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php sapcoursecode

refreshment reminder
1. setting u/ interval, periodic, email sender, name and subject di general setting
cron akan menambah sendiri period jika sudah expired dan refreshment > 0, misal training A: 20090426 - 20090430 maka akan otomatis dibuat periode 20100426 - 20100430
c:\xampp\php\php.exe e:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php training refreshment

2. mandatory reminder 
c:\xampp\php\php.exe e:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php reminder schedule
di smart : 
c:\xampp\php\php.exe e:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php reminderschedule schedule

3. refreshment reminder with defined participant
c:\xampp\php\php.exe e:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php training refreshment participantisdefined


THEME
a. saat ini, default logo di : 'images/web-pole.gif' .
prioritas : 
   1. logo yang di maintain di general setting. , kalau ga ada -> 2
   2. logo di theme '/theme/<nama-theme>/images/logo-header.gif' , kalau ga ada -> 3
   3. 'images/web-pole.gif'

b. saat ini, background image u/ certificate, by default ada di './images/sertifikat/bgpermata.gif'
prioritas : 
    1. image di './theme/<nama-theme>/images/bg-certificate.gif' , kl ga ada ->
    2. './images/sertifikat/bgpermata.gif'

c. custom email reminder content.
content saat ini di './system/application/views/reminder/message.html' 
prioritas : 
   1. template di './theme/<nama-theme>/views/reminder/message.html' , kl ga ada filenya maka ke no 2.
   2. './system/application/views/reminder/message.html' 



database maintenance cron 
c:\xampp\php\php.exe e:\dedy\kerjaan\netpolitan\lms2\adilahsoft\index.php cron

