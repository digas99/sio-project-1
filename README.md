# Project \#1 - Vulnerabilities

## Security of Information and Organizations 2021/2022

Departamento de Electrónica, Telecomunicações e Informática - Universidade de Aveiro

## Table of contents:
1. [About](#about)
2. [Setup](#setup)
3. [Vulnerabilities](#vulnerabilities)
4. [Authors](#authors)

### About

This web app represents an administration area (user-friendly back-office) of a news blog, where administrators can manage the news posted on the blog.

### Setup

To setup the app, first make sure to have [Docker](https://www.docker.com/) running on your machine. [[How to here]](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-18-04)

Then, run the following commands in the CLI:
```
$ sudo chmod +x run.sh
$ ./run.sh
```
or
```
$ sudo chmod -R a+rwx ${PWD}/app
$ sudo chmod -R a+rwx ${PWD}/app_sec

$ sudo docker build -t webapp .
$ sudo docker run -dti --name app -p 80:80 webapp
```
The web server will, then, be running on localhost:80.

### Vulnerabilities

| CWE | Name |
|:---:|------|
| [CWE-79](https://cwe.mitre.org/data/definitions/79.html) | Improper Neutralization of Input During Web Page Generation ('Cross-site Scripting')|
| [CWE-89](https://cwe.mitre.org/data/definitions/89.html) | Improper Neutralization of Special Elements used in an SQL Command ('SQL Injection')|
| [CWE-200](https://cwe.mitre.org/data/definitions/200.html) | Exposure of Sensitive Information to an Unauthorized Actor|
| [CWE-256](https://cwe.mitre.org/data/definitions/256.html) | Plaintext Storage of a Password & [CWE-311](https://cwe.mitre.org/data/definitions/311.html) - Missing Encryption of Sensitive Data|
| [CWE-306](https://cwe.mitre.org/data/definitions/306.html) | Missing Authentication for Critical Function|
| [CWE-425](https://cwe.mitre.org/data/definitions/425.html) | Direct Request ('Forced Browsing') & [CWE-288](https://cwe.mitre.org/data/definitions/288.html) - Authentication Bypass Using an Alternate Path or Channel|
| [CWE-434](https://cwe.mitre.org/data/definitions/434.html) | Unrestricted Upload of File with Dangerous Type & [CWE-20](https://cwe.mitre.org/data/definitions/20.html) - Improper Input Validation|
| [CWE-472](https://cwe.mitre.org/data/definitions/472.html) | External Control of Assumed-Immutable Web Parameter|
| [CWE-521](https://cwe.mitre.org/data/definitions/521.html) | Weak Password Requirements|
| [CWE-532](https://cwe.mitre.org/data/definitions/532.html) | Insertion of Sensitive Information into Log File|
| [CWE-549](https://cwe.mitre.org/data/definitions/549.html) | Missing Password Field Masking|
| [CWE-552](https://cwe.mitre.org/data/definitions/552.html) | Files or Directories Accessible to External Parties|
| [CWE-799](https://cwe.mitre.org/data/definitions/799.html) | Improper Control of Interaction Frequency & [CWE-307](https://cwe.mitre.org/data/definitions/307.html) - Improper Restriction of Excessive Authentication Attempts|
| [CWE-862](https://cwe.mitre.org/data/definitions/862.html) | Missing Authorization & [CWE-522](https://cwe.mitre.org/data/definitions/522.html) - Insufficiently Protected Credentials|

### Authors

|NMec | Name | Email|
|-----|------|------|
|88755 | Carlos Rafael de Jesus Palma Costa | carlospalmacosta@ua.pt|
|88930 | João Tomás Borges Simões | jtsimoes@ua.pt|
|88964 | Afonso Domingos Cardoso | afonsocardoso@ua.pt|
|90327 | Diogo Costa Correia | diogo.correia99@ua.pt|
