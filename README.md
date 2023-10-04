# Discord-Webhooks-IP-Whitelisting
Simple PHP code to impose an IP restriction on Discord Webhooks.

# Usage

## Arabic tutorial:
- [Youtube](https://youtu.be/HiG_5YvFEhE)

## English tutorial:
- Download the discord folder to your environment, such as Apache -> htdocs.
- Rename the test.htaccess file to .htaccess.
- Open the .htaccess file and replace YOUR_SERVER_IP with your machine's IP.
- Open the LOGs-System.lua file and insert your Discord webhook links in the same manner as explained in the file.
- Open the send.php file and change the $FirstTimeSetup variable to true. Put your IP or domain in $DomainOrIP and set the $SSL variable to true if you have an SSL certificate.
- Now, go to your browser and access the send.php file, for example: http://1.1.1.1/discord/send.php.
- You should see a "Setup Done" note on a blank page. Now, go back to send.php and set the $FirstTimeSetup variable to false.
- In the folder, you will find a new file called New-File.lua. In this file, you will discover the new webhook links. You can use them wherever you need.
- Optional: If you want to add a new webhook, simply go to the LOGs-System.lua file and add the webhook as a new variable in the file with any name. The original Discord webhook will be the variable's value. Then, go to the New-File.lua file and add a new variable with the same name, and its value will be the same as the last URL, but change the "t" GET parameter to match the variable name.
