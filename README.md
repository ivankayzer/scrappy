# scrappy

This is a web page scraper that allows you to define your own scripts and run them periodically.

e.g.

Creating a task for a page https://www.ceneo.pl/85615970 with a script 

```javascript
return document
  .querySelector('.product-top__price .price-format .price')
  .innerText
```

will check the page with selected interval and will notify the user of selector text changes

## Technologies used
- PHP 7.4 and Symfony 5.2
- MariaDB
- Redis
- Ngrok (for Telegram bot domain registration)
- RabbitMQ

## Demo

Step 1             |  Step 2                    | Output
:-----------------:|:-------------------------:|:------------------------------:
![](https://i.imgur.com/ZPGYFSj.png)  |  ![](https://i.imgur.com/SYEbrcO.png) |  ![](https://i.imgur.com/rjNa6tg.png)


## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)