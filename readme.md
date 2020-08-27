# The application form for psychological experiment
That is the online form for psychological experiment which enables experimenters to recieve applications from the participants. Also experimenters can regsiter new experiment in this platform, and participants are able to choose some experiments by registering their available dates for participation in some experiments.

# Requirement
- PHP(>=7.2.4)
- MySQL
- Node

# Set up
- git clone https://github.com/anoiro/portfolio_1/
- composer install
- php artisan migrate --seed
- php artisan serve

# Usage
## In case you are experimenter
- Access to 'http://127.0.0.1/exper/register'
- Register as a demo user
    - LabID: 1
    - Name: experimenter1
    - E-Mail Address: 'experimenter1@sample.com'
    - Password: 'experimenter1'

## In case you are participant
- Access to 'http://127.0.0.1/user/register'
- Register as a demo user
    - Student Number: 99990001
    - Name: participant1
    - Gender: Male
    - Age: 22
    - E-Mail Address: 'participant1@sample.com'
    - Password: 'participant1'

# DEMO
## In case you are experimenter
![experimenterCase](https://user-images.githubusercontent.com/45758121/91308018-a6335680-e7e9-11ea-9a07-68c2bb44b96c.gif)

## In case you are participant
![participantCase](https://user-images.githubusercontent.com/45758121/91308323-14781900-e7ea-11ea-9eaf-1201956d5e39.gif)

# Note
- In case you are logged in as an experimenter, the extension of image file is needed to be jpeg.
- Imange file is not displayed normally in localhost because image file is saved in database as binary data. But in Heroku, image file is displayed normally without any problem.
