<!-- Source file for MDTPL, check this repo for more info: https://github.com/fritylo/md-tpl -->

# Fast start

Before you started use this plugin, you must configure php.ini file, to use [php mail function](https://www.php.net/manual/en/function.mail.php). In this tutorial we will explain how to do it in Ubuntu Linux and Apache2 or Nginx server. You can find another solution.

## Installing `sendmail` on Ubuntu

[Source](https://gist.github.com/adamstac/7462202).

This should help you get Sendmail installed with basic configuration on Ubuntu.

1. If sendmail isn't installed, install it: `sudo apt-get install sendmail`
2. Configure `/etc/hosts` file: `nano /etc/hosts` 
3. Investigate {yourhostname}: `hostname`
4. Also, {domain} is domain of your site, where sendmail installed.
3. Make sure the line looks like this: `127.0.0.1  localhost  {yourhostname}  {domain}`
4. Run Sendmail's config and answer 'Y' to everything: `sudo sendmailconfig`
5. If you use Apache2, then restart apache2 `sudo service apache2 restart`
6. If you use Nginx, then you don't need restart.

## Update php.ini file

I'm using php7.4, your version could be another, so change 7.4 in all given paths to your version.

### Apache2

My php.ini file is `/etc/php/7.4/apache2/php.ini`, because I'm using apache2. If you will change `/etc/php/7.4/cli/php.ini`, it won't give any changes.

### Nginx

My php.ini file is `/etc/php/7.4/fpm/php.ini`, because I'm using nginx with php-fpm config.


Change content of this file to next one:
```ini
[mail function]
; For Win32 only.
SMTP = 

; For win32 only
sendmail_from = 

; For Unix only
sendmail_path = /usr/sbin/sendmail -t -i
```
[Source](https://www.tutorialspoint.com/php/php_sending_emails.htm#:~:text=The%20configuration%20for%20Linux,are%20ready%20to%20go%20%E2%88%92).

If you use apache2, then restart apache2:
```bash
sudo apache2ctl restart
```
If you use nginx, then you don't need restart.

You can check sendmail configuration via `phpinfo()` function. Find `sendmail_path` property and check if value the same, that you write to php.ini file.

You have finished configuration and ready to use plugin. Have fun :)

## How to check logs if something went wrong?

All logs are stored in `/var/log/mail.*`. There are two log files from `sendmail`:

- `/var/log/mail.log` - file with all stuff.
- `/var/log/mail.err` - file with errors only.

Check them to figure out where is problem.

## Frequent Mistakes

- Typo in `php.ini - sendmail_path` property.<br>**Symptoms:** php mail function return false.<br>**Solution:** check path in sendmail_path property of php.ini file.
- Mistake in `/etc/hosts`.<br>**Symptoms:** sendmail take very long time.<br>**Solution:** check if you add domain and hostname to ths file.