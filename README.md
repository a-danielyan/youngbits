![Spudu](http://Spudu.com/content/logo/PNG/logo_300x150.png)
#### _Version 1.5.5_

Spudu is a self-hosted open source application for managing your invoices, clients and payments.    
For more information visit __[Spudu.com](https://Spudu.com)__ or try the __[demo](https://demo.Spudu.com)__.

---

### Quick Installation

1. Download the latest version [from the Spudu website](https://Spudu.com/downloads).
2. Extract the package and copy all files to your webserver / webspace.
3. Make a copy of the `ipconfig.php.example` file and rename this copy to `ipconfig.php`.
4. Open the `ipconfig.php` file and add your URL like specified in the file.
5. Open `http://your-Spudu-domain.com/index.php/setup` and follow the instructions.


_Notice: Please download Spudu from our [website](https://Spudu.com/downloads) only as the packages contain additional needed components. If you are a developer, read the [development guide](DEVELOPMENT.md)._

#### Remove `index.php` from the URL

If you want to remove `index.php` from the URL, follow these instructions. However, this is an optional step and not a requirement. If it's not working correctly, take a step back and use the application with out removing that part from the URL.

1. Make sure that [mod_rewrite](https://go.Spudu.com/apachemodrewrite) is enabled on your web server.
2. Set the `REMOVE_INDEXPHP` setting in your `ipconfig.php` to `true`.
3. Rename the `htaccess` file to `.htaccess`

If you want to install Spudu in a subfolder (e.g. `http://your-Spudu-domain.com/invoices/`) you have to change the `ipconfig.php` and `.htaccess` file. The instructions can be found within the files.

---

### Support / Development / Chat

Need some help or want to talk with other about Spudu? Follow these links to get in touch.

[![Wiki](https://img.shields.io/badge/Help%3A-Official%20Wiki-429ae1.svg)](https://wiki.Spudu.com/)  
[![Community Forums](https://img.shields.io/badge/Help%3A-Community%20Forums-429ae1.svg)](https://community.Spudu.com/)  
[![Slack Chat](https://img.shields.io/badge/Development%3A-Slack%20Chat-429ae1.svg)](https://Spudu-slack.herokuapp.com/)  
[![Issue Tracker](https://img.shields.io/badge/Development%3A-Issue%20Tracker-429ae1.svg)](https://development.Spudu.com/)  
[![Roadmap](https://img.shields.io/badge/Development%3A-Roadmap-429ae1.svg)](https://go.Spudu.com/roadmapv1)  
[![Contribution Guide](https://img.shields.io/badge/Development%3A-Contribution%20Guide-429ae1.svg)](CONTRIBUTING.md)  

---

### Security Vulnerabilities

If you discover a security vulnerability please send an e-mail to mail@Spudu.com before disclosing the vulnerability to the public.
All security vulnerabilities will be promptly addressed.

---

> _The name 'Spudu' and the Spudu logo are both copyright by Kovah.de and Spudu.com
and their usage is restricted! For more information visit Spudu.com/license-copyright_
