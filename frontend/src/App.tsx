import './App.css'
import OrganizationComponent from './features/Organization'
import MainLayout from './layouts/MainLayout'
import { store } from './store'
import { Provider } from 'react-redux'

function App() {

  return (
    <Provider store={store}>
      <MainLayout>
        <OrganizationComponent/>
      </MainLayout>
    </Provider>
  )
}

export default App
