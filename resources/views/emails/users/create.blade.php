<x-mail::message>
# Welcome to Blue Star Packing Admin

Dear {{$name}}

We create a user for you in our administrator platform, next you have your data access

<ul>
    <li><b>Username:</b> {{$username}}</li>
    <li><b>Password:</b> {{$password}}</li>
</ul>

<x-mail::button :url="$url">
Log in
</x-mail::button>

Thanks and remember you change your password at first login.<br>
Regards, Blue Star Packing Inc.
</x-mail::message>
