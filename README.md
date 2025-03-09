Сборка для поднятия сервера через Docker

<<<<<<< Установка Nginx >>>>>>>

- sudo apt update & apt upgrade
- sudo apt install nginx

<<<<<<< Установка Docker >>>>>>>

- Устанавливаем дополнительные пакеты

<pre class="core--x9b5">  <div class="copyButton--6B33">
    <div data-v-637396bf="" class="wrapper wrapper__svg-is-inherit" style="width: 24px; height: 24px;"><svg data-v-637396bf="" width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" alt="icons/copy.svg" aria-label="icons/copy.svg" loading="lazy" class="icon"><g data-v-637396bf="" clip-path="url(#clip0_16516_17600)"><path data-v-637396bf="" d="M7 9.667C7 8.95967 7.28099 8.28131 7.78115 7.78115C8.28131 7.28099 8.95967 7 9.667 7H18.333C18.6832 7 19.03 7.06898 19.3536 7.20301C19.6772 7.33704 19.9712 7.53349 20.2189 7.78115C20.4665 8.0288 20.663 8.32281 20.797 8.64638C20.931 8.96996 21 9.31676 21 9.667V18.333C21 18.6832 20.931 19.03 20.797 19.3536C20.663 19.6772 20.4665 19.9712 20.2189 20.2189C19.9712 20.4665 19.6772 20.663 19.3536 20.797C19.03 20.931 18.6832 21 18.333 21H9.667C9.31676 21 8.96996 20.931 8.64638 20.797C8.32281 20.663 8.0288 20.4665 7.78115 20.2189C7.53349 19.9712 7.33704 19.6772 7.20301 19.3536C7.06898 19.03 7 18.6832 7 18.333V9.667Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><path data-v-637396bf="" d="M4.012 16.737C3.70534 16.5622 3.45027 16.3095 3.27258 16.0045C3.09488 15.6995 3.00085 15.353 3 15V5C3 3.9 3.9 3 5 3H15C15.75 3 16.158 3.385 16.5 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></g><defs data-v-637396bf=""><clipPath data-v-637396bf="" id="clip0_16516_17600"><rect data-v-637396bf="" width="24" height="24" fill="white"></rect></clipPath></defs></svg></div>
  </div>
  <code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">sudo apt-get install docker-compose</code>
</pre>

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">sudo apt install curl software-properties-common ca-certificates apt-transport-https -y
</code>

- Импортируем GPG-ключ

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">wget -O- https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor | sudo tee /etc/apt/keyrings/docker.gpg > /dev/null
</code>

- Добавляем репозиторий докера

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">echo "deb [arch=amd64 signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu jammy stable"| sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
</code>

- Установка Docker

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">sudo apt update & apt install docker-ce -y & systemctl status docker
</code>

<<<<<<< Установка Docker-compose >>>>>>>

- Установка Git

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">sudo apt-get install git
</code>

- Клонирование репозитория с Git

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">git clone https://github.com/docker/compose.git
</code>

- Загрузка Docker-compose v2.32.4

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">sudo curl -L "https://github.com/docker/compose/releases/download/v2.32.4/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
</code>

- Изменим права доступа скачанного файла

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">sudo chmod +x /usr/local/bin/docker-compose
</code>

- Устанавливаем сам Docker-compose

<code class="hljs--Qdn- hljs language-undefined" data-highlighted="yes">sudo apt-get install docker-compose
</code>

<<<<<<< В папке Nginx конфиг файлы >>>>>>>

- В папке Nginx конфиг файлы:

1. Их закинуть в /etc/nginx/sites-available
2. Создать символические ссылки:
   ln -s /etc/nginx/sites-available/ustarg.dev.conf /etc/nginx/sites-enabled
   ln -s /etc/nginx/sites-available/sql.ustarg.dev.conf /etc/nginx/sites-enabled
