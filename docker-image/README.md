### Как потестить во время разработки

Тестово собрать имэйдж:
```shell
docker build -f docker/prod.dockerfile -t dqc:test .
```

посмотреть что там:
```shell
docker run -it dqc:test bash
```

запустить тулзы на хостовую папку: 
```shell
# phpstan
docker run -v ../test_app:/app -w /app dqc:test phpstan -l5 analyze ./

# psalm init создает файл, нужно запустить с правильным юзером, чтоб потом свободно править файл 
docker run -v ../test_app:/app -w /app -u `id -u`:`id -g` dqc:test psalm --init

# проверку можно запускать из под рута
docker run -v ../test_app:/app -w /app dqc:test psalm
```