## Maddie Library Project
This project is meant to be a library for all of my own physical media. This includes not only what I own, but who I have leant it out to.

## The Stack
This project was created using Laravel on the backend and Vuejs on the frontend.

## Features
### Database:
- Sqlite was used simply because it is easy enough to implement and good enough for the purposes of this application.

### Backend:
- Sorting and filtering handled server-side.
- Models for media are represented using single table inheritance(STI).
- Public API's are handled through the backend as well, as to hide/obfuscate api keys, headers, etc..
- Oauth workflow for spotify to handle refreshing of api token.

### Frontend: 
- VueJS used on the frontend, mainly leveraging the composition API.
- Typescript used on the frontend, with union types to represent the STI models.
- Fully responsive design using custom composable and media queries.
- Uses calls to backend api to gather information, and auto-fill forms based on media type, from several different public API's.

## How to run by yourself:
Unfortunately, running this app on your own may be a bit frustrating. First, you will need to clone the repository. 

You will need a .env file in the root of theproject containing some api keys:
- GIANTBOMB_API_KEY - api key generated from Giantbomb account
- TMDB_API_KEY - api key generated from TMDB account
- SPOTIFY_CLIENT_ID, SPOTIFY_CLIENT_SECRET - from a spotify developer account with credentials for a project
- SPOTIFY_TOKEN_URL - This is just the spotify api endpoint for tokens: https://accounts.spotify.com/api/token

With this file in place, all you have to do is go to the root and run both:
- php artisan serve
- npm run dev
for the front and backend respectively.

## Live Version:
Minimum Viable Product is nearing completion, but as of now, this project is not yet hosted.
