**Setup your Drupal site using docksal**

Step 1:
Install Docksal: bash <(curl -fsSL https://get.docksal.io)

Step 2: 
Reconfigure apache to listen to different host and ports

sudo vi /etc/apache2/ports.conf

Change Listen 80 
to 
Listen 8080

sudo nano /etc/apache2/sites-enabled/000-default.conf
Change 
<VirtualHost *:80>

To 
<VirtualHost *:8080>


sudo service apache2 restart
 
Go to project Repository 

run  command "fin init"
