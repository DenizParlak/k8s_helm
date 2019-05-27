# k8s_helm
node.js &amp; php application with minikube - helm


=======
## Pre Requirements

- minikube
- helm & tiller
- docker
- kubectl

## Instructions

1-) Execute commands to deploy tiller:

curl https://raw.githubusercontent.com/kubernetes/helm/master/scripts/get > helm.sh && chmod 700 helm.sh && ./helm.sh && helm init

Note: helm/tiller must be ready before to continue on this step. To check:

kubectl get pods --namespace kube-system

and 'tiller-deploy' should be running as pod.

2-) Go to 'mysql' folder and execute command:

helm upgrade mysql helm/ --install

3-) Link local docker repos to minikube

eval $(minikube docker-env)

4-) Go to 'app' folder and execute commands:

docker build -t app:latest .

helm upgrade app helm/ --install

5-) Go to 'nodejs' folder and execute commands:

docker build -t nodejsapp .

helm upgrade nodejs helm/ --install


---

The project have 5 main components: Web server, PHP application, node.js application, MySQL database and helm charts.

I created a Dockerfile via php:apache image. This image would install mysql package inside, copy my index.php file to DocumentRoot and expose 80 port.

src/ directory contains index.php file. This PHP file also include all requirements to access mysql service / fetch information from sample db and serve via HTTP.

helm/values.yaml file included parameters and values for kubernetes directives and it's work as linked to helm/templates/ directory.

In helm/templates directory, I've two yaml files here one of this for deployment and another file for web server service to expose. I used helm values and kubernetes secrets to prevent hard coded datas in file.

To access it from kubectl we will need to run "kubectl get secrets" which will list down all secrets. In this case, our secret for mysql is mysql-secrets so to get the content of it use command "kubectl get secret mysql-secrets -o yaml"

Here the encrypted text next to the key is the actualy value which is base64 encoded. So to view the value you copy it i.e "YnVyYWtfZGI=" and then go to https://www.base64decode.net/ or some other way to decode the string like | base64 decode command.

service.yaml file contains selector and port information to expose the service.

In mysql side, I created helm chart too for deployment process. I used '3306' port as NodePort. In templates directory, I created deployment.yaml file like web server and also created pvc.yaml & pv.yaml files to provide persistend storage volume on host. Also I keep secret.yaml file in there. Lastly, service.yaml file linked to values.yaml for port information.

To serve node application we need just deploy to both of yaml files in nodejs/ directory.

# Screenshots
