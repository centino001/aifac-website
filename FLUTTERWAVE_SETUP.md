# Flutterwave Payment Integration Setup Guide

This document provides instructions for setting up Flutterwave payment gateway integration in the Anyen Iyak Foundation application.

## Prerequisites

- A Flutterwave account (Sign up at [https://flutterwave.com](https://flutterwave.com))
- Access to Flutterwave Dashboard
- Laravel application with proper web server setup

## Step 1: Get Flutterwave API Keys

1. Log in to your [Flutterwave Dashboard](https://dashboard.flutterwave.com)
2. Navigate to **Settings** → **API Keys**
3. You'll find the following keys:
   - **Public Key** (starts with `FLWPUBK_`)
   - **Secret Key** (starts with `FLWSECK_`)
   - **Encryption Key**

**Note:** Flutterwave provides separate keys for Test Mode and Live Mode. Start with Test Mode keys for development.

## Step 2: Configure Environment Variables

Add the following environment variables to your `.env` file:

```env
# Flutterwave Configuration
FLUTTERWAVE_PUBLIC_KEY=your_public_key_here
FLUTTERWAVE_SECRET_KEY=your_secret_key_here
FLUTTERWAVE_ENCRYPTION_KEY=your_encryption_key_here
FLUTTERWAVE_PAYMENT_URL=https://api.flutterwave.com/v3
```

### Example (Test Mode):
```env
FLUTTERWAVE_PUBLIC_KEY=FLWPUBK_TEST-xxxxxxxxxxxxx-X
FLUTTERWAVE_SECRET_KEY=FLWSECK_TEST-xxxxxxxxxxxxx
FLUTTERWAVE_ENCRYPTION_KEY=FLWSECK_TESTxxxxxxxxxxx
FLUTTERWAVE_PAYMENT_URL=https://api.flutterwave.com/v3
```

## Step 3: Run Database Migrations

Run the migration to update the payments table for Flutterwave:

```bash
php artisan migrate
```

This will:
- Rename `paystack_reference` to `flutterwave_reference`
- Rename `paystack_transaction_id` to `flutterwave_transaction_id`
- Rename `paystack_response` to `flutterwave_response`
- Remove `paystack_access_code` column
- Add `flutterwave_link` column
- Update database indexes

## Step 4: Remove Old Paystack Package

Remove the Paystack package from your dependencies:

```bash
composer remove yabacon/paystack-php
composer update
```

## Step 5: Configure Webhook (Optional but Recommended)

Webhooks allow Flutterwave to notify your application about payment events.

1. In your Flutterwave Dashboard, go to **Settings** → **Webhooks**
2. Set the webhook URL to: `https://yourdomain.com/payment/webhook`
3. Save your webhook hash/secret

Add to your `.env`:
```env
FLUTTERWAVE_WEBHOOK_HASH=your_webhook_hash_here
```

## Step 6: Test the Integration

### Using Test Cards

Flutterwave provides test cards for development:

**Successful Transaction:**
- Card Number: `5531886652142950`
- CVV: `564`
- Expiry: Any future date
- PIN: `3310`
- OTP: `12345`

**Failed Transaction:**
- Card Number: `5143010522339965`
- CVV: Any 3 digits
- Expiry: Any future date

### Testing Flow

1. Navigate to your donation page
2. Fill in the donation form
3. Click "Proceed to Payment"
4. You should be redirected to Flutterwave's payment page
5. Use the test card details above
6. Complete the payment
7. You should be redirected back to your success page

## Payment Flow Overview

```
User Submits Donation Form
    ↓
POST /payment/initialize
    ↓
FlutterwaveService::initializePayment()
    ↓
Payment Record Created (Status: pending)
    ↓
Flutterwave API Called
    ↓
User Redirected to Flutterwave Payment Page
    ↓
User Completes Payment
    ↓
Flutterwave Redirects to /payment/callback
    ↓
FlutterwaveService::verifyPayment()
    ↓
Payment Record Updated (Status: successful/failed)
    ↓
User Redirected to Success/Failed Page
```

## API Routes

The following routes are available for payment processing:

- `POST /payment/initialize` - Initialize a new payment
- `GET /payment/callback` - Handle Flutterwave callback
- `GET /payment/verify/{transactionId}` - Verify a payment manually
- `GET /payment/failed` - Payment failure page

## Payment Methods Supported

Flutterwave supports multiple payment methods:

- **Card Payments** - Visa, Mastercard, Verve
- **Bank Transfers** - Direct bank transfers
- **USSD** - Mobile banking codes
- **Mobile Money** - MTN, Airtel, etc.
- **QR Code** - Scan and pay

## Security Best Practices

1. **Never expose your Secret Key** - Keep it in `.env` file only
2. **Use HTTPS** - Flutterwave requires HTTPS for live mode
3. **Verify all payments** - Always verify payment status on callback
4. **Validate webhook signatures** - If using webhooks
5. **Keep logs** - Log all payment transactions for audit trail

## Switching to Live Mode

When ready to go live:

1. In Flutterwave Dashboard, switch to **Live Mode**
2. Get your Live API keys
3. Update `.env` with Live keys:
   ```env
   FLUTTERWAVE_PUBLIC_KEY=FLWPUBK-xxxxxxxxxxxxx-X
   FLUTTERWAVE_SECRET_KEY=FLWSECK-xxxxxxxxxxxxx
   FLUTTERWAVE_ENCRYPTION_KEY=xxxxxxxxxxxxx
   ```
4. Ensure your application is using HTTPS
5. Test thoroughly before accepting real payments

## Troubleshooting

### Payment initialization fails
- Verify your API keys are correct
- Check that your `.env` file is properly loaded
- Ensure you have internet connection
- Check Laravel logs at `storage/logs/laravel.log`

### Callback not working
- Verify the callback URL is correct in your route
- Check that your application is publicly accessible
- Ensure CSRF protection is not blocking the callback

### Payment verification fails
- Check the transaction ID is correct
- Verify your Secret Key is valid
- Ensure the payment was actually completed on Flutterwave

## Support and Resources

- **Flutterwave Documentation:** [https://developer.flutterwave.com](https://developer.flutterwave.com)
- **Flutterwave Support:** [https://flutterwave.com/support](https://flutterwave.com/support)
- **API Reference:** [https://developer.flutterwave.com/reference](https://developer.flutterwave.com/reference)

## Code Reference

### FlutterwaveService Location
- Service: `app/Services/FlutterwaveService.php`
- Controller: `app/Http/Controllers/PaymentController.php`
- Model: `app/Models/Payment.php`
- Routes: `routes/web.php`
- Views: 
  - `resources/views/livewire/pages/payment-gateway.blade.php`
  - `resources/views/livewire/pages/payment-success.blade.php`
  - `resources/views/livewire/pages/payment-failed.blade.php`

## Migration from Paystack

If you're migrating from Paystack:

1. The migration script automatically renames database columns
2. Old payment records will still be accessible
3. New payments will use Flutterwave
4. Consider keeping Paystack data for historical records

---

**Last Updated:** October 24, 2025
**Version:** 1.0.0

