# MatchPage

> MatchPage is a simple list of api wrappers for the different sports organizations API.

> 🚧 **This project is heavily under construction!** 🚧 As excited as you may be, there aren't much organization in this project supported yet.

## API

#####API Usage:
######The api url is

```
https://matchpage-date.herokuapp.com/api.php
```

######There are a few required parameters:
Data: It is the id of the api wrapper you want to use.

```
example ?data=be.basketball.vlaanderen
```

Function: It is the function you want to use.

```
example ?function=getNotFinished
```

club_id: It is the id of the club you want to use.

```
example ?club_id=BVBL1171
```

If we combine the above three parameters, we get the following url:

```
https://matchpage-date.herokuapp.com/api.php?data=be.basketball.vlaanderen&function=getNotFinished&club_id=BVBL1171
```

#####API Wrappers in the development phase:
the developer api is a list of all the api wrappers, also the ones that are in the development phase.

######The api url is

```
https://matchpage-date.herokuapp.com/developer.php
```

######There are a few required parameters:
Data: It is the id of the api wrapper you want to use.

```
example ?data=be.basketball.vlaanderen
```

Function: It is the function you want to use.

```
example ?function=getNotFinished
```

club_id: It is the id of the club you want to use.

```
example ?club_id=BVBL1171
```

If we combine the above three parameters, we get the following url:

```
https://matchpage-date.herokuapp.com/developer.php?data=be.basketball.vlaanderen&function=getNotFinished&club_id=BVBL1171
```

## Included APIs

| Organization         | Status |
| -------------------- | ------ |
| Basketbal Vlaanderen | ⏳     |

<!-- | Example of finished one                     | ✅     |
| Example of not finished and not in progress | ❌     | -->

## Contributing

Create a fork of this repository and make your changes there. Then, submit a pull request. You can also create a new issue to ask for a new feature.

More information about how to contribute to this project can be found [here](https://docs.matchpage.eu/data-collector/contributing).

## License

Licensed under the Apache License, Version 2.0. Copyright 2022 MatseVH. [Copy of the license](LICENSE.txt).

The api data is licensed by the respective organization. Please check the respective organization's website for more information.
