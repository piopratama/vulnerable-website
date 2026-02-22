[![DOI](https://zenodo.org/badge/832942289.svg)](https://doi.org/10.5281/zenodo.18732309)

# Vulnerable Website – Web Security Demonstration Project

This project is a deliberately vulnerable web application created for educational and cybersecurity training purposes. It demonstrates common web security vulnerabilities that can occur due to improper programming practices, along with secure implementations for comparison.

Warning:  
This application contains intentional security vulnerabilities. It must only be used in a controlled environment (e.g., localhost or laboratory environment). Do NOT deploy this project to a public production server.

---

## Project Purpose

The goal of this project is to help:

- Students understand how common web vulnerabilities occur  
- Developers learn the consequences of insecure coding  
- Security practitioners practice identifying and mitigating vulnerabilities  
- Educators demonstrate real-world attack scenarios safely  

This repository includes both vulnerable and secure versions of several common web attack vectors.

---

## Included Vulnerabilities

The project demonstrates the following web security issues:

- Cross-Site Scripting (XSS)
- Cross-Site Request Forgery (CSRF)
- Directory Traversal
- Server-Side Request Forgery (SSRF)
- Insecure File Upload
- Insecure Login Implementation

Secure implementations are also provided for comparison:

| Vulnerable File | Secure Version |
|----------------|---------------|
| xss.php | secure_xss.php |
| csrf.php | secure_csrf.php |
| directory_traversal.php | secure_directory_traversal.php |
| ssrf.php | secure_ssrf.php |
| upload.php | secure_upload.php |
| login.php | secure_login.php |

---

## Project Structure

```
vulnerable-website/
├── includes/
├── public/
├── uploads/
├── vendor/
├── config.php
├── init.sql
├── malicious.php
├── composer.json
├── composer.lock
├── .htaccess
├── .secure_htaccess
├── LICENSE
```

Inside the `public/` directory:

```
about.php
contact.php
csrf.php
directory_traversal.php
index.html
index.php
login.php
profile.php
robot.txt
secure_csrf.php
secure_directory_traversal.php
secure_login.php
secure_ssrf.php
secure_upload.php
secure_xss.php
ssrf.php
upload.php
xss.php
```

---

## How to Run

### Using PHP Built-in Server

```bash
git clone https://github.com/piopratama/vulnerable-website.git
cd vulnerable-website/public
php -S localhost:8000
```

Open in browser:

```
http://localhost:8000
```

### Using XAMPP / WAMP / LAMP

1. Place the project folder inside your web server directory (e.g., htdocs).
2. Start Apache.
3. Open in browser:
   ```
   http://localhost/vulnerable-website/public
   ```

---

## Educational Use Cases

This project can be used for:

- Cybersecurity laboratory exercises
- Ethical hacking practice
- Secure coding workshops
- Academic demonstrations
- Penetration testing training

---

## Learning Outcomes

By exploring this project, users will learn:

- How common web vulnerabilities are exploited
- Why input validation and output encoding matter
- The importance of authentication and authorization checks
- Secure programming best practices
- Defensive coding strategies

---

## Citation

If you use this project for academic or research purposes, please cite:

Pratama, I. W. P. (2026). Vulnerable Website – Web Security Demonstration Project [Software].  
https://doi.org/10.5281/zenodo.18732309

---

## License

This project is licensed under the MIT License.

---

## Disclaimer

This software is intentionally vulnerable. The author is not responsible for misuse of this code. It is strictly intended for educational use, security research, and controlled laboratory environments.
