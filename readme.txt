=== WooCommerce Boleto - PDF Add-on ===
Contributors: claudiosanches
Tags: woocommerce, boleto, ticket, payment, bank slip, pdf
Requires at least: 4.0
Tested up to: 4.3
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Generate PDF files for WooCommerce Boleto

== Description ==

Gere arquivos PDF para os seus boletos do [WooCommerce Boleto](https://wordpress.org/plugins/woocommerce-boleto/).

= Compatibilidade =

Compatível com as versões 2.3.x e 2.4.x do [WooCommerce](https://wordpress.org/plugins/woocommerce/).

É requerido o plugin [WooCommerce Boleto](https://wordpress.org/plugins/woocommerce-boleto/) para gerar os boletos.

= Instalação =

Confira o nosso guia de instalação e configuração do WooCommerce Boleto - PDF Add-on na aba [Installation](http://wordpress.org/plugins/wc-boleto-pdf/installation/).

= Dúvidas? =

Você pode esclarecer suas dúvidas usando:

* A nossa sessão de [FAQ](http://wordpress.org/plugins/wc-boleto-pdf/faq/).
* Utilizando o nosso [fórum no Github](https://github.com/claudiosmweb/wc-boleto-pdf).
* Criando um tópico no [fórum de ajuda do WordPress](http://wordpress.org/support/plugin/wc-boleto-pdf).

= Coloborar =

Você pode contribuir com código-fonte em nossa página no [GitHub](https://github.com/claudiosmweb/wc-boleto-pdf).

== Installation ==

= Instalação do plugin: =

* Envie os arquivos do plugin para a pasta wp-content/plugins, ou instale usando o instalador de plugins do WordPress.
* Ative o plugin.

= Requerimentos: =

* Ter instalada a versão mais recente do [WooCommerce](http://wordpress.org/plugins/woocommerce/).
* E ter instalada a versão mais recente do [WooCommerce Boleto](https://wordpress.org/plugins/woocommerce-boleto/).
* Ter sua loja online e acessível para qualquer um.

= Configurações do Plugin: =

Com o plugin instalado acesse o admin do WordPress e entre em "WooCommerce" > "Configurações" > "Finalizar compra" > "Boleto".

Configure o seu boleto normalmente e no final das configurações é possível encontrar a sessão "Configurações para PDF", onde é possível selecionar a API que será utilizada para gerar os boletos em PDF.

Note que o seu site precisa estar online e acessível para qualquer um, pois a APIs que geram os PDFs precisam acessar sua página para gerar o arquivo, caso o contrário o cliente será redirecionado para a página do boleto como normalmente.

Pronto, sua loja já vai estar mostrando os boletos no formato PDF.

== Frequently Asked Questions ==

= Qual é a licença do plugin? =

Este plugin esta licenciado como GPL.

= O que eu preciso para utilizar este plugin? =

* A versão mais recente do [WooCommerce](http://wordpress.org/plugins/woocommerce/).
* A versão mais recente do [WooCommerce Boleto](https://wordpress.org/plugins/woocommerce-boleto/).
* Ter sua loja online e acessível para qualquer um (as APIs que geram os boletos precisam acessar o link dos seus boletos).

= Não é gerado nenhum boleto em PDF, o que esta acontecendo? =

Caso os boletos não aparecem no formato PDF, pode ser porque sua página não esta online ou tem algo bloqueado requisições externas. Uma vez que este plugin utiliza API de serviços externos, é necessário que sua página seja acessível para qualquer um. Caso o contrário o cliente irá ver o boleto no formato HTML como normalmente sempre viu.

Além disso links de e-mails que já foram enviados para os clientes não serão abertos no formato PDF, apenas nos e-mails enviados após a instalação deste plugin.

= Mais dúvidas relacionadas ao funcionamento do plugin? =

Por favor, caso você tenha algum problema com o funcionamento do plugin, [abra um tópico no fórum do plugin](https://wordpress.org/support/plugin/wc-boleto-pdf#postform) com o link arquivo de log (ative ele nas opções do plugin e tente fazer uma compra, depois vá até WooCommerce > Status do Sistema, selecione o log do *boleto_pdf* e copie os dados, depois crie um link usando o [pastebin.com](http://pastebin.com) ou o [gist.github.com](http://gist.github.com)), desta forma fica mais rápido para fazer o diagnóstico.

== Screenshots ==

1. Configurações do plugin.

== Changelog ==

= 1.0.0 - 2015/09/07 =

* Initial version.

== Upgrade Notice ==

= 1.0.0 =

* Initial version.

== License ==

WooCommerce Boleto - PDF Add-on is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

WooCommerce Boleto - PDF Add-on is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with WooCommerce Boleto - PDF Add-on. If not, see <http://www.gnu.org/licenses/>.
