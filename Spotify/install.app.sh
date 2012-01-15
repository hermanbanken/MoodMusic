#!/bin/sh
SPOTIFYPATH=$(pwd -P $0)
ln -s $SPOTIFYPATH ~/Spotify
open spotify:app:ike
