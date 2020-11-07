
# Web auction

> Web auction application for an antique items seller. The application
will allow users to bid on antique items displayed in the site and admin users to set up items
for auction. Product management and auctioning are within the scope of the application;
shopping cart and payment integration are not. 

## Built With

- PHP
- Laravel
- MySQL

## API

### Live domain: https://xtrmdarc-web-auction-sc.herokuapp.com
- `GET /items` 
  - Endpoint to retrieve all active items on sale for the auction website.
- `GET /items/{id}` 
  - Endpoint to retrieve information about one item on sale.
- `POST /bids` 
  - Endpoint to create a new bid.
- `PUT /user/{id}` 
  - Endpoint to update user information like max_auto_bid_amount.
- `POST /login` 
  - Endpoint to authenticate user.

## How to install locally

- Clone this project into your local environment. 
- Run the command `composer install` to install all the required dependencies.
- Run the command `php artisan migrate:refresh --seed` to create and populate on local database.
- Run the command `php artisan serve`.

## Potential Future Features

- Add realtime updates to user for outbidded bids.
- Handle auction winner scenario.

## Authors

👤 **Diego Antonio Reyes Coronado**

- Github: [@xtrmdarc](https://github.com/xtrmdarc)
- Twitter: [@diegoreyesco](https://twitter.com/DiegoAn91629127)
- Linkedin: [diegoreyesco](https://www.linkedin.com/in/diego-reyes-coronado)

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

Feel free to check the [issues page](https://github.com/xtrmdarc/web-auction-app-sc/issues).

## Show your support

Give a ⭐️ if you like this project!
