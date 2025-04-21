#!/bin/bash

echo "starting firewall.."

ufw allow in on event_network

echo "firewall worked successfully!"
