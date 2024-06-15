import { configureStore } from '@reduxjs/toolkit';
import tableReducer from './store/TableSlice';

export const store = configureStore({
  reducer: {
    table: tableReducer,
  },
});