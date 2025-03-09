Сборка для поднятия сервера через Docker

Установка Nginx

- sudo apt update & apt upgrade
- sudo apt install nginx

Установка Docker

- sudo apt install curl software-properties-common ca-certificates apt-transport-https -y
- wget -O- https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor | sudo tee /etc/apt/keyrings/docker.gpg > /dev/null
- echo "deb [arch=amd64 signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu jammy stable"| sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
- sudo apt update
- sudo apt install docker-ce -y

<pre class="core--x9b5">  
<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">sudo systemctl status docker</code>
</pre>
В папке Nginx конфиг файлы:

1. Их закинуть в /etc/nginx/sites-available
2. Создать символические ссылки:
   ln -s /etc/nginx/sites-available/ustarg.dev.conf /etc/nginx/sites-enabled
   ln -s /etc/nginx/sites-available/sql.ustarg.dev.conf /etc/nginx/sites-enabled
