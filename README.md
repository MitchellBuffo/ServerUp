Сборка для поднятия сервера через Docker

<<<<<<< Установка Nginx >>>>>>>

- sudo apt update & apt upgrade
- sudo apt install nginx

<<<<<<< Установка Docker >>>>>>>
Устанавливаем дополнительные пакеты

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">
sudo apt install curl software-properties-common ca-certificates apt-transport-https -y
</code>
Импортируем GPG-ключ

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">
wget -O- https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor | sudo tee /etc/apt/keyrings/docker.gpg > /dev/null
</code>
Добавляем репозиторий докера

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">
echo "deb [arch=amd64 signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu jammy stable"| sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
</code>
Установка Docker

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">
sudo apt update
sudo apt install docker-ce -y
sudo systemctl status docker
</code>

<<<<<<< Установка Docker-compose >>>>>>>
Установка Git

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">
sudo apt-get install git
</code>
Клонирование репозитория с Git

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">
git clone https://github.com/docker/compose.git
</code>
Загрузка Docker-compose v2.32.4

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">
sudo curl -L "https://github.com/docker/compose/releases/download/v2.32.4/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
</code>
Изменим права доступа скачанного файла

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">
sudo chmod +x /usr/local/bin/docker-compose
</code>
Устанавливаем сам Docker-compose

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">
sudo apt-get install docker-compose
</code>

<<<<<<< В папке Nginx конфиг файлы >>>>>>>

В папке Nginx конфиг файлы:

1. Их закинуть в /etc/nginx/sites-available
2. Создать символические ссылки:
   ln -s /etc/nginx/sites-available/ustarg.dev.conf /etc/nginx/sites-enabled
   ln -s /etc/nginx/sites-available/sql.ustarg.dev.conf /etc/nginx/sites-enabled
