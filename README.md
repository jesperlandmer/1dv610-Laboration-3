# What is Implemented?

For a better view of what is implemented and what is to come, please visit the [Project Page](https://github.com/jesperlandmer/1dv610-Laboration-3/projects/1).

Alternatively, you could visit our [Open Issues](https://github.com/jesperlandmer/1dv610-Laboration-3/issues?utf8=%E2%9C%93&q=is%3Aissue%20is%3Aopen) or [Closed Issues](https://github.com/jesperlandmer/1dv610-Laboration-3/issues?utf8=%E2%9C%93&q=is%3Aissue%20is%3Aclosed) to view which use cases are implemented or not.

# How to test?

UC1 - UC4 are testable using the [Automatic Test Application](http://csquiz.lnu.se:25083/index.php).
Make sure you type in the right URL for the application, and type in username and password for an existing user.

Testing instructions for [UC5](https://github.com/jesperlandmer/1dv610-Laboration-3/issues/5) and [UC6](https://github.com/jesperlandmer/1dv610-Laboration-3/issues/6) are defined in their corresponding issues.

# How to install?

First check your PHP version

    php -v
    
The application requires the latest stable PHP version 7.1.6

To install the application on a local server, download any solution stack containing Apache, MySQL and PHP. Pull the repository files, and add them to .htdocs.

To install the application on a public server, I suggest using Digital Ocean. I recommend checking out ["How To Set Up Automatic Deployment with Git with a VPS"](https://www.digitalocean.com/community/tutorials/how-to-set-up-automatic-deployment-with-git-with-a-vps) on Digital Ocean.

Also, don't forget to setup your MySQL Table. I'd suggest just making a simple user table, like this:

    +----------+-------------+------+-----+---------+----------------+
    | Field    | Type        | Null | Key | Default | Extra          |
    +----------+-------------+------+-----+---------+----------------+
    | user_id  | int(11)     | NO   | PRI | NULL    | auto_increment |
    | username | varchar(80) | NO   | UNI | NULL    |                |
    | password | text        | NO   |     | NULL    |                |
    +----------+-------------+------+-----+---------+----------------+

Don't forget to set the variables for your Database host, name, pass and table defined in PDOService.php. My suggestion is to create class called PDOVariables and add the needed database info to well represented constants.
