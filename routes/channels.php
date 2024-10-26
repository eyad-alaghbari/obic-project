<?php

use App\Broadcasting\ProductChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('product',ProductChannel::class);
