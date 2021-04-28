# Magento 2 TESTIMONIALS

This module adds an easy way to use testimonials in your Magento store. In this module, the admin can approve, disapprove, delete and update testimonials.

## Installation

- Create the following folders inside the Magento app folder
> `code/Egio/Testimonials`
- Download [.zip](https://github.com/zakaria-janah/magento-2-testimonials/archive/main.zip)
- The path should be **app/code/Egio/Testimonials**
- Extract the **.zip** files into the **Testimonials** folder

> php bin/magento module:enable Egio_Testimonials<br/>
> php bin/magento setup:upgrade<br/>
> php bin/magento setup:di:compile<br/>
> php bin/magento setup:static-content:deploy<br/>
> php bin/magento cache:clean<br/>
> php bin/magento cache:flush<br/>

The URL path to the testimonials page will be: http://example.com/testimonials/

## Configuration

The module can be enabled/disabled on **Stores -> Configuration -> EGIO EXTENSIONS -> Testimonials**

## Screenshots

![Screenshot 1](images/Screenshot_1.jpeg)

![Screenshot 2](images/Screenshot_2.png)

![Screenshot 3](images/Screenshot_3.png)
