# Great task for Great Fullstack Developer

#### Deployment
* http://testio.deividasz.lt/ This is fully deployed my version of testio app.
Feel free to test api using this environment. Example: `http://testio.deividasz.lt/api/login/`

#### Requirements
* Docker (recommended)
* PHP 7.2, Composer and nginx/apache (only if not using docker)   

#### Installation (Docker dev)
1. Make sure docker is running on your local machine
2. cd to project main directory
3. cp .env.dist .env
4. Change LOCAL_NGINX_PORT variable in .env file to any free port on your machine
5. Run ./start-dev.sh
6. Run `docker-compose exec php composer install`
6. You can now access api at 127.0.0.1:8680 (if LOCAL_NGINX_PORT=8680 in .env)
7. To stop docker containers call ./stop-dev.sh

#### Known issues
* Very poor exception handling
* No documentation
* Github state variable is not secure. Because for all request same state variable is used.
* No SSL on my deployment environment
* .env.gist contains real github api info. I left it there to speed up project installation.

#### Workflow
1. Call /api/login/ api to get github login url
2. After callback from github you should have code and state.
3. Call /api/login/access-token (POST) with variables code and state. Example:
`
{
  "code": "878963c434a71cdba2ef",
  "state": "random"
}
`
4. Add received access-token to Authorization header
5. Call /api/issue/ endpoint to receive all your account issues from github
6. Call /api/issue/{owner}/{repo}/{issueId} (Without Authorization header) to receive comments for specific issue example:
```
/api/issue/octocat/Hello-World/1
```