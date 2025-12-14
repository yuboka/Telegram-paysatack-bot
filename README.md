# Telegram Paystack Subscription Bot

## Features
- Telegram bot (Webhook)
- Paystack payments
- Admin dashboard
- Subscription expiry cron
- SQLite database
- Railway ready

## Setup
1. Clone repo
2. Deploy to Railway
3. Set environment variables:
   - BOT_TOKEN
   - PAYSTACK_SECRET
   - ADMIN_ID
4. Set Telegram webhook:
   https://api.telegram.org/bot<TOKEN>/setWebhook?url=https://YOUR-APP.up.railway.app/telegram_webhook.php

## Cron
Set Railway cron:
0 * * * * php cron/expire_subscriptions.php
