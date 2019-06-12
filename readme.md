### Instructions
- run `docker-compose up`

### Requirements
- Docker
- Docker-Compose

### Notes
- Original site used WordPress 5.2.1

### Run project with Xdebug support
- run the following (replace the ip address for your host machine´s ip):
```sh
docker-compose down -v
export HOST_IP=192.168.0.15
docker-compose up --build
```

- If on windows:
```sh
docker-compose down -v
$env:HOST_IP ="192.168.0.15";
docker-compose up --build
```
