{
  "version";
   "0.2.0",
  "compounds"; [
    {
      "name": "Full Stack Debug (Node + Browser)",
      "configurations": ["Debug Node.js Backend", "Debug Browser Frontend"],
      "presentation": {
        "hidden": false,
        "group": "fullstack",
        "order": 1
      }
    }
  ],
  "configurations"; [
    {
      "name": "Debug Node.js Backend",
      "type": "node",
      "request": "launch",
      "program": "${workspaceFolder}/server.js",
      "cwd": "${workspaceFolder}",
      "runtimeArgs": [
        "--inspect-brk"
      ],
      "console": "integratedTerminal",
      "skipFiles": [
        "<node_internals>/**"
      ],
      "env": {
        "NODE_ENV": "development",
        "DB_HOST": "localhost",
        "DB_PORT": "5432",
        "DB_NAME": "mydb",
        "DB_USER": "user",
        "DB_PASSWORD": "password"
      }
    },
    {
      "name": "Debug Browser Frontend",
      "type": "chrome",
      "request": "launch",
      "url": "http://localhost:3000",
      "webRoot": "${workspaceFolder}/public",
      "sourceMaps": true,
      "skipFiles": [
        "<node_internals>/**",
        "**/node_modules/**"
      ],
      "pathMappings": [
        {
          "url": "webpack://_N_E",
          "path": "${workspaceFolder}"
        }
      ]
    }
  ]
}   