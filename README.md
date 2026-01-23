# Bookeasy

## Considerações dos desenvolvedores

> Este software é de uso exclusivo e não pode ser copiado, modificado ou redistribuído sem permissão expressa dos autores [Bruno Bellinaso Brasil](https://github.com/bellinaso) e [Arthur Bernardo Paul](https://github.com/arthurbp08).


## O que é o Bookeasy?
<p align="justify">
O <strong>Bookeasy</strong> é uma plataforma SaaS desenvolvida para facilitar o gerenciamento de agendamentos de serviços, permitindo que estabelecimentos, prestadores de serviços e usuários finais interajam de forma simples, rápida e centralizada.
</p>

<p align="justify">
Diferentemente das soluções tradicionais, o Bookeasy busca eliminar a dependência de ligações telefônicas e longas trocas de mensagens, oferecendo ao próprio usuário a possibilidade de realizar, consultar e gerenciar seus agendamentos de forma autônoma e intuitiva.
</p>

## Proposta
<p align="justify">
O objetivo do Bookeasy é otimizar o processo de marcação de serviços, proporcionando:

- Maior organização para prestadores de serviço  
- Autonomia para os usuários  
- Redução de erros e conflitos de horário  
- Melhor experiência no atendimento  
</p>

## Tecnologias Utilizadas
<div display="inline-block">
    <!--php-->
    <img align="center" alt="php" src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white"/>
    <!--mysql-->
    <img align="center" alt="mysql" src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white"/>
    <!--html-->
    <img align="center" alt="html5" src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white"/>
    <!--css-->
    <img align="center" alt="css3" src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white"/>
    <!--js-->
    <img align="center" alt="javascript" src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black"/>
</div>

## Capturas de tela

<img align="center" alt="index page" width="45%" src="./public/screenshots/1-index.png"/>
<img align="center" alt="home page" width="45%" src="./public/screenshots/2-home.png"/>
<img align="center" alt="user view establishments" width="45%" src="./public/screenshots/3-establishment-user.png"/>
<img align="center" alt="user schedule" width="45%" src="./public/screenshots/4-my-schedules.png"/>
<img align="center" alt="admin view establishments" width="45%" src="./public/screenshots/5-establishment-admin.png"/>
<img align="center" alt="admin page" width="45%" src="./public/screenshots/6-admin1.png"/>


## Como executar localmente

1. Utilize o PHP na versão **8.3.0** para garantir maior compatibilidade com o projeto;
2. Execute o script `./model/bookease_database_script.sql` para criar o banco de dados experimental;
3. Para habilitar a funcionalidade de mapas, substitua `API_KEY` em `./view/establishments.php` por uma chave válida da API do Google Maps;
4. Divirta-se!