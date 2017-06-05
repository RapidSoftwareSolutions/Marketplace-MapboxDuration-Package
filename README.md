[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/MapboxDuration/functions?utm_source=RapidAPIGitHub_MapboxDurationFunctions&utm_medium=button&utm_content=RapidAPI_GitHub)

# MapboxDuration Package
Calculation of travel time (in sec) between points based on the type of transport
* Domain: [Mapbox](https://www.mapbox.com)
* Credentials: accessToken

## How to get credentials: 
1. You can get your accessToken from your account ([Mapbox Account](https://www.mapbox.com/studio/account/tokens/))
2. Please contact support for your access token for this API ([Mapbox Support](https://www.mapbox.com/contact/))
 
 
## Custom datatypes: 
 |Datatype|Description|Example
 |--------|-----------|----------
 |Datepicker|String which includes date and time|```2016-05-28 00:00:00```
 |Map|String which includes latitude and longitude coma separated|```50.37, 26.56```
 |List|Simple array|```["123", "sample"]``` 
 |Select|String with predefined values|```sample```
 |Array|Array of objects|```[{"Second name":"123","Age":"12","Photo":"sdf","Draft":"sdfsdf"},{"name":"adi","Second name":"bla","Age":"4","Photo":"asfserwe","Draft":"sdfsdf"}] ```
 
## MapboxDuration.getDrivingDuration
Сalculate the duration of travel by car

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| The api key obtained from Mapbox
| coordinates| List       | List of Maps (coordinates) minimum 2 pairs of coordinates. Maximum 100 pairs.

## MapboxDuration.getDrivingDurationByFile
Сalculate the duration of travel by car (json file coordinates)

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| The api key obtained from Mapbox
| coordinates| File       | File with coordinates in json format. Maximum 100 pairs of coordinates like [[longitude1,latitude1], [longitude2,latitude2]].

## MapboxDuration.getWalkingDuration
Сalculate the duration of travel by walking

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| The api key obtained from Mapbox
| coordinates| List       | List of Maps (coordinates) minimum 2 pairs of coordinates. Maximum 100 pairs.

## MapboxDuration.getWalkingDurationByFile
Сalculate the duration of travel by walking (json file coordinates)

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| The api key obtained from Mapbox
| coordinates| File       | File with coordinates in json format. Maximum 100 pairs of coordinates like [[longitude1,latitude1], [longitude2,latitude2]].

## MapboxDuration.getCyclingDuration
Сalculate the duration of travel by cycling

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| The api key obtained from Mapbox
| coordinates| List       | List of Maps (coordinates) minimum 2 pairs of coordinates. Maximum 100 pairs.

## MapboxDuration.getCyclingDurationByFile
Сalculate the duration of travel by cycling (json file coordinates)

| Field      | Type       | Description
|------------|------------|----------
| accessToken| credentials| The api key obtained from Mapbox
| coordinates| File       | File with coordinates in json format. Maximum 100 pairs of coordinates like [[longitude1,latitude1], [longitude2,latitude2]].

#### Examples
MapboxDuration.getCyclingDuration
```code
{
    "accessToken": "Your-accessToken-here",
    "coordinates": [{
        "-122.42,37.78",
        "-77.03, 38.91"
    }]
}
```
Response
```code
{
    "callback":"success",
    "contextWrites":
    {
        "to":[
            {
                "code":"Ok",
                "durations":[
                    [0,14753.7,23437],
                    [14639.3,0,29524.6],
                    [22498.4,29708.1,0]
                ]
            }
        ]
    }
}
```

MapboxDuration.getCyclingDurationByFile
coordinates.json
```code
[
    [13.41894, 52.50055],
    [14.10293, 52.50055],
    [13.50116, 53.10293]
]
```
Response
```code
{
    "callback": "success",
    "contextWrites": 
    {
        "to":[
            {
                "code": "Ok",
                "durations": [
                    [0,14753.7,23437],
                    [14639.3,0,29524.6],
                    [22498.4,29708.1,0]
                ]
            }
        ]
    }
}
```
