# Laravel-Password
Basic tools for updating a user's password on create/update

This package adds a very simple trait to automatically save the user id who created this model.

Simply add the "\BinaryCabin\LaravelPassword\Traits\HasPassword;" trait to your model:

```
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    use \BinaryCabin\LaravelAuthor\Traits\HasAuthorUser;

}
```

Now when you create a new user:
- A temporary password will be generated if it isn't added in the ::create attributes
- A password passed in the attributes will automatically be hashed

And when calling $user->update:
- A password passed in the attributes will automatically be hashed

NOTE: Be careful to remove any existing hashing that exists in your application, as this will cause the password to be hashed twice. For example, Laravel's default register controller contains:

```
return User::create([
    'name' => $data['name'],
    'email' => $data['email'],
    'password' => bcrypt($data['password']),
]);
```

Since the User::create method will now hash the included password, you can update this to:

```
return User::create([
    'name' => $data['name'],
    'email' => $data['email'],
    'password' => $data['password'],
]);
```

Additionally, the default ResetPasswordController will hash the User's password as well. Add this to the controller to overwrite this functionality:

```
protected function resetPassword($user, $password){
    $user->password = $password;
    $user->setRememberToken(\Illuminate\Support\Str::random(60));
    $user->save();
    event(new \Illuminate\Auth\Events\PasswordReset($user));
    $this->guard()->login($user);
}
```    
