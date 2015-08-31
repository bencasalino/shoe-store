Code Review 4 8-27-15

By Ben Casalino

Description

This app allows users to add shoe stores, and particular brands for each shoe store!

DATABASE SET UP
---------------

CREATE DATABASE shoes;
USE shoes; 3.CREATE TABLE stores (id SERIAL PRIMARY KEY, name VARCHAR(255), location VARCHAR (255)); 4.CREATE TABLE brand (id SERIAL PRIMARY KEY, name VARCHAR (255));


Technologies Used

PHP, MYSQL, PHPUnit, Silex, Twig, HTML, CSS, Bootstrap 3 

Legal

Copyright (c) 2015 Ben Casalino

This software is licensed under the MIT license.

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
