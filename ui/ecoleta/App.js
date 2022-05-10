import 'react-native-gesture-handler';
import * as React from 'react';
import { View } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { createDrawerNavigator } from '@react-navigation/drawer';
import { Text } from 'react-native-elements';

import Home from './src/screens/Home';
import Regiao from './src/screens/Regiao';
import PontoDeColeta from './src/screens/PontoDeColeta';
import ItensDoPonto from './src/screens/ItensDoPonto';
import SacolaPendente from './src/screens/SacolaPendente';
import SacolaEntregue from './src/screens/SacolaEntregue';
import ResgateSacolaPendente from './src/screens/ResgateSacolaPendente';
import ResgateSacolaFinalizada from './src/screens/ResgateSacolaFinalizada';
import ItensPendentes from './src/screens/ItensPendentes';
import ItensFinalizados from './src/screens/ItensFinalizados';

function Exit(){
  return (
    <View>
      <Text h1>Sair</Text>
    </View>
  );
}

function Profile(){
  return (
    <View>
      <Text h1>Perfil</Text>
    </View>
  );
}

function HomeScreen({ navigation }) {
  return (
    <Stack.Navigator
    screenOptions={{
      headerShown: false
    }}
    >
      <Stack.Screen name="Início" component={Home} />
      <Stack.Screen name="Região" component={Regiao} />
      <Stack.Screen name="Pontos de Coleta" component={PontoDeColeta} />
      <Stack.Screen name="Itens do Ponto" component={ItensDoPonto} />
    </Stack.Navigator>
  );
}

const LeftDrawer = createDrawerNavigator();

const LeftDrawerScreen = () => {
  return (
    <LeftDrawer.Navigator screenOptions={{ drawerPosition: 'left' }}>
      <LeftDrawer.Screen name="Ecoleta" component={HomeScreen} />
      <LeftDrawer.Screen name="Sacolas Pendentes" component={SacolaPendente} />
      <LeftDrawer.Screen name="Itens Pendentes" component={ItensPendentes} />
      <LeftDrawer.Screen name="Sacolas Entregues" component={SacolaEntregue} />
      <LeftDrawer.Screen name="Itens Entregues" component={ItensFinalizados} />
      <LeftDrawer.Screen name="Resgate de Sacolas Pendentes" component={ResgateSacolaPendente} />
      <LeftDrawer.Screen name="Resgate de Sacolas Finalizadas" component={ResgateSacolaFinalizada} />
      {/* <LeftDrawer.Screen name="Perfil" component={Profile} />
      <LeftDrawer.Screen name="Sair" component={Exit} /> */}
    </LeftDrawer.Navigator>
  );
};

const RightDrawer = createDrawerNavigator();

const RightDrawerScreen = () => {
  return (
    <RightDrawer.Navigator
      screenOptions={{ drawerPosition: 'right', headerShown: false }}
    >
      <RightDrawer.Screen name="HomeDrawer" component={LeftDrawerScreen} />
    </RightDrawer.Navigator>
  );
};

const Stack = createNativeStackNavigator();

export default function App() {
  return (
    <NavigationContainer>
      <RightDrawerScreen />
    </NavigationContainer>
  );
}