Getting started
=============

Minimum requirements
-------------------

This bundle needs minimum requirements specified below to work properly.

- PHP 8.0 or newer
- Symfony 5.2 or newer

Dependencies
-------------

- [LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle) is used to decode JWT token.
  It will require configuration of itself. You can see the details by checking it's repository.

Installation
-----------

Run composer

```bash
composer require fkolcu/attribute-authorization-bundle
```

Usage
-----

1. Before authorization

   To authorize a method or controller itself, you only need to put
   `Authorize` attribute on either method or controller class.

- Class with attribute

  ```php
  #[Authorize('ROLE_ADMIN')]
  class AdminController 
  {
  }
  ```

- Method with attribute

  ```php
  class PostController
  {
      #[Authorize('ROLE_ADMIN')]
      #[Route(path: '/posts', methods:'POST')]
      public function addPost(){}
      
      #[Authorize()] // same as #[Authorize('ROLE_USER')]
      #[Route(path: '/posts/{id}/comments', methods:'POST')]
      public funct commentPost(){}
  }
  ```

- Multiple roles

  ```php
  #[Authorize('ROLE_MANAGER', 'ROLE_ADMIN')]
  class AdminController
  {
      # Both manager and admin can access to methods below
      public function viewReport(){}
      public function listUsers(){}
      
      # Only admin can access the following method
      #[Authorize('ROLE_ADMIN')]
      public function deleteUser(){}
  }
  ```

2. After authorization

   When authorization is successful, a property will be added into the request.
   You will be having a `UserInterface` object in the request with `authorizedUser` key.
   This will be available to access in method after successful authorization.

```php
use use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class PostController
{
    public function commentPost(Request $request)
    {
        /** @var UserInterface $authorizedUser */
        $authorizedUser = $request->get('authorizedUser');
        
        # Identifier could be anything you give before encoding JWT token
        # An email, username or GUID
        $identifier = $authorizedUser->getUserIdentifier();
        $roles = $authorizedUser->getRoles();
        
        # ...
    }
}
```

Setting JWT token
--------------

A JWT token should at least include 2 key for bundle to work.

- `identifier` (REQUIRED) This can be an email address, or a username, or a user GUID, or anything
  unique.
- `roles` (NOT REQUIRED) This must be an array of string and include at least 1 role.
  Roles can be named anything. If `roles` key is not specified in JWT token, it will be considered
  as `ROLE_USER` default.
