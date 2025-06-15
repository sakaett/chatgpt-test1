import React from 'react';
import { createRoot } from 'react-dom/client';
import {IndexContainer} from '../containers/indexcontainer';

// index.blade.phpのid="app"を読み込む
const container = document.getElementById('root');
const app = createRoot(container!); // createRoot(container!) if you use TypeScript


app.render(
    <IndexContainer />
);