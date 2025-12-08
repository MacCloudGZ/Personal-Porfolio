# Personal Portfolio

Personal project demonstrating a dynamic portfolio website.

## Website properties

Default color palette used on the site:

| Color           | Hex     |
| --------------- | ------- |
| Red             | #FF0000 |
| Light Red       | #E3311D |
| Black           | #050507 |
| Dark Gray-Black | #362E2D |
| Gray            | #7C8685 |
| Light Gray      | #AAACA1 |

## Setup

- Setup database: import or execute the SQL in `Setup_Database.sql` on your SQL server.
- Current database: `CurrDatabase.sql` is a preconfigured snapshot. Use it if you prefer the existing data.

Default credentials for the sample account:

```
Username: admin
Password: admin
```

CurrDatabase.sql account:

```
Username: admin
Password: MacCloud
```

## Database tables

Notes:
- IDs refer to primary keys.
- Some tables are dynamic (one-to-many relationships).

### PersonalData

| id | firstname | lastname | middlename | suffix | birthdate   | status       |
| --:| --------- | -------: | ---------: | ------ | ----------- | ------------:|
| 1  | Anon      | Nyms     | Anonymost  | NULL   | 2000-01-01  | free-lancer  |

Status choices:
- employed
- free-lancer
- unemployed
- retired

### Contacts (one person can have multiple contacts)

| id | contact_location | contact     |
| --:| :---------------:| -----------:|
| 1  | 01+              | 8473020029  |
| 1  | 98+              | 9276827821  |

### Login

| id | username | password  |
| --:| -------- | --------: |
| 1  | anon     | ierjiajje |

### ProfileImages

| profile_img_locale | profile_id | image_part |
| ------------------ | ---------: | ---------: |
| /images/profile.jpg| 1          | 1          |
| /images/bg.jpg     | 1          | 2          |

Notes:
- image_part: 1 = profile image, 2 = background/profile banner

### Projects

| project_id | project_name | description  | project_status | layout_type |
| ---------: | ------------ | ------------ | -------------- | ----------: |
| 1          | testing      | lorem ipsum  | ongoing        | 3           |
| 2          | new data     | lorem ipsum  | completed      | 1           |

### ProjectImages

| project_id | image_locale   | layout |
| ---------: | -------------- | -----: |
| 1          | /images/p1-1.jpg | 1    |
| 1          | /images/p1-2.jpg | 2    |
| 1          | /images/p1-3.jpg | 3    |
| 2          | /images/p2-1.jpg | 1    |
