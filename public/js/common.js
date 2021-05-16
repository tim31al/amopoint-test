'use strict';

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
