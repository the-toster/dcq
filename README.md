# Dockerized code quality tools

Набор инструментов для проверки качества PHP кода, запускаемый из докера.

## Установка

```shell
curl -sSf https://the-toster.github.io/dcq/install.sh | sh
```

## Использование
```shell
cd your_project
dcq psalm --init
dcq psalm
```

## Какие инструменты доступны
```
vimeo/psalm
phpstan/phpstan
```

## TODO: Использование в `CI`
Наверное можно использовать dcq как базовый образ для задачи 

#### Gitlab
```yaml
job-name:
  image: ghcr.io/the-toster/dcq:latest
```
#### GitHub Actions
```yaml
container: ghcr.io/the-toster/dcq:latest
```

А в гитхабе скорее всего можно прям через докер гонять.
TODO: сделать свой экшен.

## Удаление
```shell
rm ~/.local/bin/dcq
```

## Ручная установка
Скачайте образ и задайте алиас используемый `dcq`:
```shell
docker pull ghcr.io/the-toster/dcq:latest && docker tag ghcr.io/the-toster/dcq:latest dcq:current
```
Скачайте [dcq](shell-helper/dcq), добавьте его в `$PATH` и сделайте исполняемым.

## Устройство 

`dcq` состоит из:
- имейджа с последними версиями инструментов (`ghcr.io/the-toster/dcq:latest`),
- консольного скрипта [dcq](shell-helper/dcq), который позволяет удобно запускать тулзы, как будто они на хосте: `dcq psalm`
 
### ./docker-image/ 
Сам образ, скрипт установки инструментов (имя пакета надо добавить в `packages.txt`).  
Скрипт установки добавляет пути до `vendor/bin` каждого инструмента в `paths.sh` (там `export PATH=$PATH...`).  
Скрипт энтрипоинта выполняет `. paths.sh`, таким образом можно передать имя любого бинарника и он запустится.  

### ./shell-helper/

[dcq](shell-helper/dcq) - шелл скрипт запуска инструментов, который подставляет текущую папку в вольюм и задает юзера, используется для локального прогона проверок.    
[installer-generator.sh](shell-helper/installer-generator.sh) - скрипт который из [dcq](shell-helper/dcq) и [installer-template.sh](shell-helper/installer-template.sh) генерирует инсталлер во время релиза  


### ./test-app/

PHP приложение на котором проверяю как работают тулзы