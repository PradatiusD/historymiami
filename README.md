# HistoryMiami

OLD IP: 69.20.113.165

```
bash sudo apachectl restart
```

```sql
mysql -uroot -ppassword history_miami_fastspot
select start_date, end_date, title, location, description, image from plugin_events_events ORDER By start_date DESC;
SELECT start_date, start_time, end_date, end_time, title, location, description, image FROM plugin_events_events INTO OUTFILE '/Users/dprada/GitHub/historymiami/theme/events.csv' FIELDS TERMINATED BY ',' ENCLOSED BY '"' LINES TERMINATED BY '\n';
```


```
mysql> show columns from plugin_events_events;
+----------------------+--------------+------+-----+---------+-----------------------------+
| Field                | Type         | Null | Key | Default | Extra                       |
+----------------------+--------------+------+-----+---------+-----------------------------+
| featured             | char(2)      | NO   |     | NULL    |                             |
| title                | varchar(255) | NO   |     | NULL    |                             |
| location             | varchar(255) | NO   |     | NULL    |                             |
| description          | mediumtext   | NO   |     | NULL    |                             |
| image                | varchar(255) | NO   |     | NULL    |                             |
| start_date           | date         | YES  |     | NULL    |                             |
| end_date             | date         | YES  |     | NULL    |                             |
| start_time           | time         | YES  |     | NULL    |                             |
| end_time             | time         | YES  |     | NULL    |                             |
+----------------------+--------------+------+-----+---------+-----------------------------+
```

HistoryMiami
101 West Flagler Street
Miami, FL 33130

<a href="http://www.facebook.com/historymiami360" target="_blank"><i class="fa fa-2x fa-facebook" aria-hidden="true"></i></a>
<a href="http://www.twitter.com/historymiami" target="_blank"><i class="fa fa-2x fa-twitter" aria-hidden="true"></i></a>
<a href="http://www.flickr.com/photos/historymiami" target="_blank"><i class="fa fa-2x fa-flickr" aria-hidden="true"></i></a>
<a href="http://www.youtube.com/historymiami" target="_blank"><i class="fa fa-2x fa-youtube" aria-hidden="true"></i></a>
<a href="http://foursquare.com/venue/1357011" target="_blank"><i class="fa fa-2x fa-foursquare" aria-hidden="true"></i></a>
<a href="http://www.tripadvisor.com/Attraction_Review-g34438-d592101-Reviews-HistoryMiami-Miami_Florida.html" target="_blank"><i class="fa fa-2x fa-tripadvisor" aria-hidden="true"></i></a>