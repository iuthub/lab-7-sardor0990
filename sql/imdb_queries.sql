USE imdb_small;

SELECT name FROM movies WHERE year = 1995;

SELECT COUNT(*) FROM actors a
    JOIN roles r ON a.id = r.actor_id
    JOIN movies m ON r.movie_id = m.id
    WHERE m.name = 'Lost in Translation';

SELECT a.first_name, a.last_name FROM actors a
    JOIN roles r ON a.id = r.actor_id
    JOIN movies m ON r.movie_id = m.id
    WHERE m.name = 'Lost in Translation';

SELECT d.first_name, d.last_name FROM directors d
    JOIN movies_directors md ON d.id = md.director_id
    JOIN movies m ON md.movie_id = m.id
    WHERE m.name = 'Fight CLub';

SELECT COUNT(*) FROM directors
    JOIN movies_directors ON id = director_id
    WHERE first_name = 'Clint' AND last_name = 'Eastwood';

SELECT m.name FROM movies m
    JOIN movies_directors md ON m.id = md.movie_id
    JOIN directors d ON md.director_id = d.id
    WHERE d.first_name = 'Clint' AND d.last_name = 'Eastwood';

SELECT d.first_name, d.last_name FROM directors d
    JOIN movies_directors md ON d.id = md.director_id
    JOIN movies m ON md.movie_id = m.id
    JOIN movies_genres mg ON m.id = mg.movie_id
    WHERE mg.genre = 'Horror';

SELECT d.first_name, d.last_name FROM directors d
    JOIN directors_genres dg ON d.id = dg.director_id
    WHERE dg.genre = 'Horror';

SELECT DISTINCT a.first_name, a.last_name FROM actors a
    JOIN roles r ON a.id = r.actor_id
    JOIN movies m ON r.movie_id = m.id
    JOIN movies_directors md ON m.id = md.movie_id
    JOIN directors d ON md.director_id = d.id
    WHERE d.first_name = 'Christopher' AND d.last_name = 'Nolan';