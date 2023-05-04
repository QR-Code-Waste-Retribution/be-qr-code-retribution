<?php

use Illuminate\Support\Facades\Broadcast;
use App\Events\QREvent;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('qr_code_retribution.{uuid}', function ($user, $roomId) {
    return true; // Modify this as per your authentication logic
});

// Broadcast::channel('private-chat.{roomId}', function ($user, $roomId) {
//     return true; // Modify this as per your authentication logic
// });

// Broadcast::channel('presence-chat.{roomId}', function ($user, $roomId) {
//     return true; // Modify this as per your authentication logic
// });

// Broadcast::channel('presence-join.{roomId}', function ($user, $roomId) {
//     return ['id' => $user->id, 'name' => $user->name]; // Modify this as per your user model
// });

// Broadcast::channel('presence-leave.{roomId}', function ($user, $roomId) {
//     return ['id' => $user->id, 'name' => $user->name]; // Modify this as per your user model
// });

// Broadcast::channel('typing.{roomId}', function ($user, $roomId) {
//     return true; // Modify this as per your authentication logic
// });

// Broadcast::channel('read.{roomId}', function ($user, $roomId) {
//     return true; // Modify this as per your authentication logic
// });

// Broadcast::channel('notification.{userId}', function ($user, $userId) {
//     return $user->id === $userId;
// });

// Broadcast::channel('global-notification', function ($user) {
//     return true; // Modify this as per your authentication logic
// });

// Broadcast::channel('online', function ($user) {
//     return true; // Modify this as per your authentication logic
// });

// Broadcast::channel('offline', function ($user) {
//     return true; // Modify this as per your authentication logic
// });

// // Other route definitions...
