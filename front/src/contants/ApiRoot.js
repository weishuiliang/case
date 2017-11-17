import login from './api/login';
import task from './api/task';
import organize from './api/organize';
import log from './api/log';

const API = {
    ...login,
    ...task,
	...organize,
	...log
};

let baseUrl = '';
if ("production" !== process.env.NODE_ENV) {
	baseUrl += 'http://localhost:9001/api';
} else {
	baseUrl = location.origin;
}

for (let i in API) {
	API[i] = baseUrl + API[i];
}

export default API;