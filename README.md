# Сборка для поднятия сервера через Docker

## Установка Nginx

-> sudo apt update & apt upgrade
-> sudo apt install nginx

## Установка Docker >>>>>>>

### Устанавливаем дополнительные пакеты

-> sudo apt install curl software-properties-common ca-certificates apt-transport-https -y

### Импортируем GPG-ключ

-> wget -O- https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor | sudo tee /etc/apt/keyrings/docker.gpg > /dev/null

### Добавляем репозиторий докера

-> echo "deb [arch=amd64 signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu jammy stable"| sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

### Установка Docker

-> sudo apt update & apt install docker-ce -y & systemctl status docker

## Установка Docker-compose

### Установка Git

-> sudo apt-get install git

### Клонирование репозитория с Git

-> git clone https://github.com/docker/compose.git

### Загрузка Docker-compose v2.32.4

-> sudo curl -L "https://github.com/docker/compose/releases/download/v2.32.4/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose

### Изменим права доступа скачанного файла

-> sudo chmod +x /usr/local/bin/docker-compose

### Устанавливаем сам Docker-compose

-> sudo apt-get install docker-compose

## Настройка Nginx

### В папке Nginx конфиг файлы

=> Их закинуть в /etc/nginx/sites-available

### Создать символические ссылки:

-> ln -s /etc/nginx/sites-available/ustarg.dev.conf /etc/nginx/sites-enabled
-> ln -s /etc/nginx/sites-available/sql.ustarg.dev.conf /etc/nginx/sites-enabled

### Прописываем домены в Hosts

-> nano /etc/hosts
127.0.0.1 ustarg.dev
127.0.0.1 sql.ustarg.dev
127.0.0.1 moorel.ru

### Создание профиля для Ustarg.dev

groupadd -g 1000 usergroup && \
 useradd -u 1000 -g usergroup -m -s /bin/bash ustarg && \
 echo "ustarg ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

### Создание пользователя в MySQL

-> docker exec -it pma /bin/bash

-> mysql -u root -p

CREATE USER 'admin'@'%' IDENTIFIED BY 'L8Xddjh-Eoo7RzgXiXR4';
GRANT ALL ON _._ TO 'admin'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
exit
