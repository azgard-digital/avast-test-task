Avast Test Task
=======================================

- Rename .env_example to .env
- Put xml file to ./xml folder
- Build dockers
```
docker-compose up --build
```
- Start export
```
chmod +x export.sh \
./export.sh -v ${filename}
```