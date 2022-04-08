FROM ubuntu:latest
#the following ARG turns off the questions normally asked for location and timezone for Apache
ENV DEBIAN_FRONTEND=noninteractive

#install all the tools you might want to use in your container
#probably should change to apt-get install -y --no-install-recommends
RUN apt update
RUN apt install -y nano
RUN apt install -y apache2
RUN apt install libapache2-mod-fcgid
RUN a2enmod proxy
RUN a2enmod proxy_fcgi

RUN apt update && apt install -y php libapache2-mod-php php-mysql

RUN apt install -y wget

# wkhtmltopdf install
RUN wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6-1/wkhtmltox_0.12.6-1.focal_amd64.deb
RUN apt install -y ./wkhtmltox_0.12.6-1.focal_amd64.deb

EXPOSE 80

# Now start the server
# run Apache in foreground
CMD  /usr/sbin/apache2ctl -D FOREGROUND

WORKDIR /var/www/html
RUN rm index.html
COPY . /var/www/html

RUN chmod -R 777 /var/www/html/temp/html
RUN chmod -R 777 /var/www/html/temp/pdf