# email-linha-comando
Envio de e-mail via linha de comando

<hr>

## Exemplo de consumo:
```
php index.php '{"host":"smtp.office365.com","user":"bonattidaniel@hotmail.com","password":"","secure":"TLS","port":587,"from":"bonattidaniel@hotmail.com","name":"Bonatti","addres":[{"email":"daniel@hsist.com.br"},{"email":"bonattidaniel@hotmail.com"},{"email":"danielcarlosbonatti@gmail.com"}],"html":true,"content":{"subject":"assunto","body":"corpo","altbody":"corpo alternativo"},"attachment":[{"file":"teste2.txt"},{"file":"teste3.txt"}]}'
```


