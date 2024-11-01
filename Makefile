start:
	docker compose up -d
build:
	docker compose up -d --build

stop:
	docker compose down

fpm:
	docker exec -it api_gold888 bash

db:
	docker exec -it db_gold888 bash

c1:
	docker exec -it client_gold888 sh
redis:
	docker exec -it redis_gold888 redis-cli	#KEYS *, GET ключ, FLUSHALL
