## commands to run the App

### Clone the App
- git clone https://github.com/haidyeed/T-order-payment.git

- cd T-order-payment

(if needed run ..)

- cp .env.example .env
- composer install
- php artisan key:generate

### Database setup & commands 
- CREATE DATABASE t-order-payment

- php artisan migrate
- php artisan db:seed

### .env setup for DB and Payment keys
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=t-order-payment
DB_USERNAME=root
DB_PASSWORD=

CREDITCARD_URL="CREDITCARD_URL"
CREDITCARD_KEY="CREDITCARD_KEY"
CREDITCARD_SECRET="CREDITCARD_SECRET"
CREDITCARD_MERCHANTID="CREDITCARD_MERCHANTID"

PAYPAL_URL="PAYMOB_URL"
PAYPAL_CLIENT_ID="PAYMOB_CLIENT_ID"
PAYPAL_CLIENT_SECRET="PAYMOB_CLIENT_SECRET"

## logs viewer url 
(rap2hpoutre package)
http://127.0.0.1:8000/logs

## APIs viewer url 
(Rakutentech package)
http://127.0.0.1:8000/request-docs

## run on ..
http://0.0.0.0:8000

## Authentication (using passport)
**any user password is 12345678    #via seeder or you may register yourself.**

📁 Project Structure (only changed files or folders)
T-order-payment/
├── app
│    └── Http
│      └── Controllers    #for CRUD methods
│      └── Requests       #for validation
│    └── Models 
│    └── Services
│      └── payments       #for payment strategy
│      └── orderService.php  #for order calculations
├── config
│   └── logging.php
│   └── payment.php
│   └── request-docs
├── database
│   └── factories
│   └── migrations
│   └── seeders
├── routes
│   └── api.php
│   └── web.php
├── storage
│   └── logs
│     └── payment
├── tests
├── .env.example
└── README.md

# Api Doc.

## Auth.
### Register
- METHOD: POST
- URL: http://127.0.0.1:8000/api/register
- BODY: {
            "email":"test@mail.com",
            "password":"11111111",
            "password_confirmation":"11111111",
            "name":"test test"
        }
- SUCCESS RESPONSE: {
                "success": "Account successfully registered.",
                "user": {
                    "name": "test test",
                    "email": "test@mail.com",
                    "updated_at": "2026-02-07T17:22:22.000000Z",
                    "created_at": "2026-02-07T17:22:22.000000Z",
                    "id": 1102
                }
            }
- ERROR RESPONSE: {
                        "errors": "Unprocessable Entity",
                        "message": {
                            "email": [
                                "The email has already been taken."
                            ]
                        }
                    }
## Login
- METHOD: POST
- URL: http://127.0.0.1:8000/api/login   
- BODY: {
            "name":"test@mail.com",
            "password":"11111111"
        }
- SUCCESS RESPONSE: {
                        "success": {
                            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9......."
                        },
                        "user": {
                            "id": 1,
                            "name": "test test",
                            "email": "test@mail.com",
                            "email_verified_at": "2026-02-06T16:20:17.000000Z",
                            "created_at": "2026-02-06T05:19:04.000000Z",
                            "updated_at": "2026-02-06T05:19:04.000000Z"
                        }
                    }
- ERROR RESPONSE: {
                    "errors": "unauthorized",
                    "message": "These credentials do not match our records."
                  }

## Product
### list all products (paginated)
- METHOD: GET
- URL: http://127.0.0.1:8000/api/products    
- AUTHORIZATION: Bearer Token
- BODY: 
- RESPONSE: {
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 135,
                "name": "Enim 7646",
                "sku": "BN-539",
                "price": 86092,
                "status": 1,
                "order": 31,
                "created_at": "2026-02-06T16:31:40.000000Z",
                "updated_at": "2026-02-06T16:31:40.000000Z"
            },
            {
                "id": 134,
                "name": "Facere 3293",
                "sku": "EY-147",
                "price": 152603,
                "status": 1,
                "order": 63,
                "created_at": "2026-02-06T16:31:40.000000Z",
                "updated_at": "2026-02-06T16:31:40.000000Z"
            },
            {
                "id": 133,
                "name": "Quasi 7264",
                "sku": "MX-690",
                "price": 543665,
                "status": 1,
                "order": 65,
                "created_at": "2026-02-06T16:31:40.000000Z",
                "updated_at": "2026-02-06T16:31:40.000000Z"
            },
            ......
        ],
        "first_page_url": "http://127.0.0.1:8000/api/products?productpage=1",
        "from": 1,
        "last_page": 3,
        "last_page_url": "http://127.0.0.1:8000/api/products?productpage=3",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "page": null,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/products?productpage=1",
                "label": "1",
                "page": 1,
                "active": true
            },
            {
                "url": "http://127.0.0.1:8000/api/products?productpage=2",
                "label": "2",
                "page": 2,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/products?productpage=3",
                "label": "3",
                "page": 3,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/products?productpage=2",
                "label": "Next &raquo;",
                "page": 2,
                "active": false
            }
        ],
        "next_page_url": "http://127.0.0.1:8000/api/products?productpage=2",
        "path": "http://127.0.0.1:8000/api/products",
        "per_page": 10,
        "prev_page_url": null,
        "to": 10,
        "total": 29
    }
}
### create product
- METHOD: POST
- URL: http://127.0.0.1:8000/api/products
- AUTHORIZATION: Bearer Token
- BODY: {
        "name": "Smartphone",
        "sku": "SP001",
        "price": 800,
        "order": 1,
        "status": 1
      }
- SUCCESS RESPONSE: {
                        "success": "Product successfully created.",
                        "product": {
                            "name": "Smartphone",
                            "sku": "SP001",
                            "price": 800,
                            "order": 1,
                            "status": 1,
                            "updated_at": "2026-02-07T17:43:55.000000Z",
                            "created_at": "2026-02-07T17:43:55.000000Z",
                            "id": 138
                        }
                    }
- ERROR RESPONSE: {
                    "message": "The sku has already been taken.",
                    "errors": {
                        "sku": [
                            "The sku has already been taken."
                        ]
                    }
                  }

## order
### create order
- METHOD: POST
- URL: http://127.0.0.1:8000/api/orders
- AUTHORIZATION: Bearer Token
- BODY: 
- SUCCESS ESPONSE: {
    "success": true,
    "order": {
        "user_id": 1,
        "total": 200.00,
        "status": "pending",
        "updated_at": "2026-02-07T15:55:03.000000Z",
        "created_at": "2026-02-07T15:55:03.000000Z",
        "id": 11,
        "products": [
            {
                "id": 1,
                "name": "sed",
                "sku": "BA-505",
                "price": 50,
                "status": 1,
                "order": 67,
                "created_at": "2026-02-06T16:20:47.000000Z",
                "updated_at": "2026-02-06T16:20:47.000000Z",
                "pivot": {
                    "order_id": 11,
                    "product_id": 1,
                    "quantity": 2,
                    "price": 50
                }
            },
            {
                "id": 3,
                "name": "Smartphone",
                "sku": "SP001",
                "price": 100,
                "status": 1,
                "order": 1,
                "created_at": "2026-02-06T15:51:55.000000Z",
                "updated_at": "2026-02-06T15:51:55.000000Z",
                "pivot": {
                    "order_id": 11,
                    "product_id": 3,
                    "quantity": 1,
                    "price": 100
                }
            }
        ]
    },
    "message": "Order created successfully"
}
- ERROR RESPONSE: {
                    "message": "The selected orderItems.0.product_id is invalid.",
                    "errors": {
                        "orderItems.0.product_id": [
                            "The selected orderItems.0.product_id is invalid."
                        ]
                    }
                  }


### list all orders
- METHOD: GET
- URL: http://127.0.0.1:8000/api/orders   
- AUTHORIZATION: Bearer Token
- BODY: 
- Response: **same as listing products but for orders listing**

### show order details
- METHOD: GET
- URL: http://127.0.0.1:8000/api/order/5   
- AUTHORIZATION: Bearer Token
- BODY: 
- SUCCESS Response: {
        "success": true,
        "order": {
                "id": 11,
                "user_id": 1,
                "total": "1650.00",
                "status": "confirmed",
                "created_at": "2026-02-07T15:55:03.000000Z",
                "updated_at": "2026-02-07T15:55:27.000000Z",
                "products": [
                    {
                        "id": 3,
                        "name": "sed",
                        "sku": "BA-505",
                        "price": 50,
                        "status": 1,
                        "order": 67,
                        "created_at": "2026-02-06T16:20:47.000000Z",
                        "updated_at": "2026-02-06T16:20:47.000000Z",
                        "pivot": {
                            "order_id": 11,
                            "product_id": 3,
                            "quantity": 1,
                            "price": 50
                        }
                    },
                    {
                        "id": 1,
                        "name": "Smartphone",
                        "sku": "SP001",
                        "price": 800,
                        "status": 1,
                        "order": 1,
                        "created_at": "2026-02-06T15:51:55.000000Z",
                        "updated_at": "2026-02-06T15:51:55.000000Z",
                        "pivot": {
                            "order_id": 11,
                            "product_id": 1,
                            "quantity": 2,
                            "price": 800
                        }
                    }
                ]
            }
        }
- ERROR RESPONSE: {
                    "success": false,
                    "message": "Order not found"
                  }  

### change order status
- METHOD: GET
- URL: http://127.0.0.1:8000/api/order/changeStatus/11/confirmed  
- AUTHORIZATION: Bearer Token
- BODY: 
- SUCCESS Response: {
    "success": true,
    "order": {
        "id": 11,
        "user_id": 1,
        "total": "1650.00",
        "status": "confirmed",
        "created_at": "2026-02-07T15:55:03.000000Z",
        "updated_at": "2026-02-07T15:55:27.000000Z"
    },
    "message": "Order status updated successfully"
}
- ERROR RESPONSE: {
    "success": false,
    "message": "Order not found"
}

### delete order
- METHOD: DELETE
- URL: http://127.0.0.1:8000/api/orders/6 
- AUTHORIZATION: Bearer Token
- BODY: 
- SUCCESS Response: {
    "success": true,
    "message": "order deleted successfully"
}
- ERROR RESPONSE: {
    "success": false,
    "message": "Cannot delete order with payments."
}

## payment
### process payment
- METHOD: POST
- URL: http://127.0.0.1:8000/api/payments/orders/11 
- AUTHORIZATION: Bearer Token
- BODY: {
  "method": "credit_card"
}
- SUCCESS Response: {
    "order_id": 11,
    "status": "successful",
    "method": "credit_card",
    "transaction_id": "CreditCard-698760eab7a2a",
    "updated_at": "2026-02-07T15:57:30.000000Z",
    "created_at": "2026-02-07T15:57:30.000000Z",
    "id": 13
}
- ERROR RESPONSE: {
    "error": "this Order does not exist"
}

### list all payment
- METHOD: GET
- URL: http://127.0.0.1:8000/api/payments
- AUTHORIZATION: Bearer Token
- BODY: 
- Response: **same as listing products but for payments listing**
