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
docker run -v ./test_app:/app -w /app dqc:test phpstan -l5 analyze ./

# psalm
docker run -v ./test_app:/app -w /app dqc:test psalm --init
docker run -v ./test_app:/app -w /app dqc:test psalm
```