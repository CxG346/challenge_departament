import { createSlice } from '@reduxjs/toolkit';

export const tableSlice = createSlice({
  name: 'table',
  initialState: {
    data: [],
    total: 0
  },
  reducers: {
    setData: (state, action) => {
      state.data = action.payload;
    },
    setTotal: (state, action) => {
      state.total = action.payload;
    }
  },
});

export const { setData, setTotal } = tableSlice.actions;

export default tableSlice.reducer;