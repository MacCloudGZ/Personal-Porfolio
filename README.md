# Personal-Porfolio
Personal Project as showing a my knowledge on making a dynamic portfolio

# Website properties
the default color pallets that is used in this website is:
| color            |"hex-color |
| -----            | --------- |
| red              | #FF0000 |
| lightish red     | #E3311D |
| black            | #050507 |
| lightish-black   | #362E2D |
| grey             | #7C8685 |
| lightish grey    | #AAACA1 |

# Configure
the default password setup is:
Username : admin
Passwordd : admin

# table section
Portfolio Table Data

Personal Data Table
| id  | firstname | lastname | middlename | Suffix | birthdate  | status |
| :-- | --------- | -------- | ---------- | ------ | ---------  | -----: |
| 1   |   Anon    |  nyms    |  Anonymost |  NULL  | 2000-01-01 | free-lancer |

status has 4 choices
| choices |
| ----------- |
| employed |
| free-lancer |
| unemployed |
| retired |
Contact table <!--dynamic table-->
<!-- an account can have more than one contacts depends on the user  -->
| *id | contact-location | contact    |
| :-- | :--------------: | -------    |
|  1  |      01+         | 8473020029 |
|  1  |      98+         | 9276827821 |

Login table 
| *id | username | password  |
| :-- | -------- | --------  |
|<id> |   anon   | ierjiajje |

Profile-Image Table
| profile_img-locale | profile_id | image-part |
| :--------- | -------- | ------- |
| ex("/image/..") | <id> | 1 | 
| ex("/image/..") | <id> | 2 | 

<!-- 1 is for the profile-->
<!-- 2 is for the background profile -->
Projects table <!--dynamic table-->

| project-id | project_name | description | project_status | layout-type |
| :--------- | ------------ | ----------- | -------------- | ----------: |
|      1     |   testing    | loremepstum |   ongoing      |      3      |
|      2     |   new data   | loremepstum |   completed    |      1      |

project image table <!--dynamic table-->

| *project-id | image-locale | layout |
| ----------- | ------------ | ------ |
|     1       | ex("/image/) |   1    |
|     1       | ex("/image/) |   2    |
|     1       | ex("/image/) |   3    |
|     2       | ex("/image/) |   1    |
