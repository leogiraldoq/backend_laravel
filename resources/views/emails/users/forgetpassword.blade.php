<x-mail::message>
<img src="https://bluestarpacking.online//layout/images/logoBlueStarPacking.png" style="height: 149px;"/>

# Restore password Blue Star Packing App

Dear {{$name}}

We restore your password, please login to the app with this provisional password

<ul>
    <li><b>Username:</b> {{$username}}</li>
    <li><b>Password:</b> {{$password}}</li>
</ul>

<x-mail::button :url="$url">
Log in
</x-mail::button>

Thanks and you need to change your password at login.<br>
Regards, Blue Star Packing Inc.
</x-mail::message>
