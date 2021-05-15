'use strict';

const LOCATION_API_URL = `http://ip-api.com/json`;
const API_URL = `http://localhost/api/stats`;
const TOKEN = `670633c2b73362dba7fdedf4`;

const loadData = async (options) => {
  const {method, data} = options;

  const headers = new Headers();
  headers.append("Authorization", `Bearer ${TOKEN}`);
  headers.append("Content-Type", "application/json");

  const response = await fetch(API_URL, {
    method,
    body: data ? JSON.stringify(data) : null,
    headers,
  });
  return await response.json();
}

const getVisitorData = async () => {
  const response = await fetch(LOCATION_API_URL);
  const data = await response.json();
  const {query, city} = data;

  return {
    ip: query,
    city,
    device: window.navigator.userAgent,
  };
};

(async () => {
  try {
    const userData = await getVisitorData();
    await loadData({method: `POST`, data: userData});
  } catch (err) {
    console.log(err);
  }
})();
