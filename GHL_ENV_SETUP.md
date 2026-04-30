# GoHighLevel Environment Variables

This project expects these GoHighLevel variables in `.env`:

```env
GHL_BASE_URL=https://services.leadconnectorhq.com
GHL_API_VERSION=2021-07-28
GHL_API_TOKEN=your-private-integration-token
GHL_LOCATION_ID=your-location-id
```

## What each variable means

- `GHL_BASE_URL`
  Use the HighLevel API base URL. For this project, keep:
  `https://services.leadconnectorhq.com`

- `GHL_API_VERSION`
  Use the API version header required by the Contacts API in this integration:
  `2021-07-28`

- `GHL_API_TOKEN`
  This is your HighLevel **Private Integration Token**.

- `GHL_LOCATION_ID`
  This is the **Sub-Account / Location ID** where the contact should be created or updated.

## How to get `GHL_API_TOKEN`

HighLevel’s official Private Integrations docs say the token is created in the HighLevel UI and used as a Bearer token for API requests.

Steps:

1. Open your HighLevel account.
2. Go to `Settings`.
3. Open `Private Integrations`.
4. Click `Create new Integration`.
5. Give it a name and description.
6. Enable the scopes needed for contacts.
7. Copy the generated token immediately.

Important:

- HighLevel shows the token when it is generated. Copy it then.
- Do not commit it to git.
- Store it only in `.env`.

## How to get `GHL_LOCATION_ID`

HighLevel’s official support docs list two easy ways:

### Option 1: Business Profile

1. Open the target sub-account in HighLevel.
2. Go to `Settings`.
3. Open `Business Profile`.
4. Copy the `Location ID`.

### Option 2: Browser URL

If you are already inside the sub-account, look at the browser URL and copy the value after `/location/` or the value in `locationId=...`.

Example:

```text
https://app.../v2/location/abc123XYZ/dashboard
```

Here, `abc123XYZ` is the location ID.

## Recommended `.env` block

```env
GHL_BASE_URL=https://services.leadconnectorhq.com
GHL_API_VERSION=2021-07-28
GHL_API_TOKEN=paste-your-private-integration-token-here
GHL_LOCATION_ID=paste-your-location-id-here
```

## Notes for this repo

- The exit-intent popup backend sends leads to HighLevel with the Contacts API.
- `GHL_BASE_URL` and `GHL_API_VERSION` usually do not need to change.
- The two values you actually need to fetch from HighLevel are:
  - `GHL_API_TOKEN`
  - `GHL_LOCATION_ID`
