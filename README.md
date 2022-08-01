# Installation

## Configure your XAMPP

- Install XAMPP
  `https://www.apachefriends.org/fr/download.html`
- Start XAMPP

## Install composer

https://getcomposer.org/download/

## Configure the project

- Clone it from github:
  `git clone git@github.com:esmia-entretien/MeetingLag.git`

- Go to the project directory
  `cd MeetingLab/`
- Install dependencies
  `composer install`
- Go to `http://localhost/phpmyadmin` and import `db.sql`

## Configure your local host

### For Windows

- Open `C:\xampp\apache\conf\extra\httpd-vhosts.conf`
- Add this code at the AND remove all Hashtag '#'
<pre><code><#VirtualHost esmia.test:80>
	ServerName esmia.test
	DocumentRoot "PATH_TO_THE_PROJECT_FOLDER/MeetingLab/public"
	<#Directory  "PATH_TO_THE_PROJECT_FOLDER/MeetingLab/public/">
		Options +Indexes +Includes +FollowSymLinks +MultiViews
		AllowOverride All
		Allow from all
		Require local
	<#/Directory>
<#/VirtualHost></code></pre>
- Open `C:\Windows\System32\drivers\etc\hosts`
- Add this
<pre>
<code>127.0.0.1     esmia.test</code>
</pre>
- Run your server (xampp)
- Go to http://esmia.test

# Running Tests
