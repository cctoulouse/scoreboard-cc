# Scoreboard Coding Cluib toulouse

## Installation

Pour installer le scoreboard il suffit de cloner de dépot puis de se déplacer dedans:

```
git clone git@github.com:cctoulouse/scoreboard-cc.git
cd scoreboard-cc
```

Puis de lancer le docker-compose:

```
sudo docker-compose up -d
```

Ensuite pour remplir la database avec des données de base (un utilisateur d'admin notament) il faut se connecter au conteneur mysql:

```
sudo docker cp ./scoreboard.sql "$(docker-compose ps -q mysql)":/db.sql
sudo docker-compose exec mysql bash
mysql -u root -ppassroot
```

Ensuite il faut taper les commandes suivantes dans le shell mysql:

```
CREATE DATABASE scoreboard
USE scoreboard
source db.sql
```

Et voila le scoreboard est setup avec comme user et mot de passe:
   - toulouse@epitech.eu
   - admintoulouse
