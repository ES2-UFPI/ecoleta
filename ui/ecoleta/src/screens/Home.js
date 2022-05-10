import React, { useEffect, useState, Component } from 'react';
import { Alert, StyleSheet, View } from 'react-native';
import { Button, Text } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';
// import { Picker } from '@react-native-picker/picker';
import { PickerInput } from '../components/PickerInput';

import api from '../services/api';

export default class Home extends Component {
  state = {
    estados: [],
    cidades: [],
    estadoSelecionado: '',
    cidadeSelecionada: ''
  }

  buscaEstados = async () => {
    await api.get(`/states`).then(response => {
      this.setState({
        estados: response.data.data.states.map(value => ({
          label: value.name,
          value: value.id,
        }))
      });
    });
  };

  componentDidMount() {
    this._unsubscribe = this.props.navigation.addListener('focus', () => {
      console.log('Atualizando tela Home');
      this.buscaEstados();
    });
  }

  componentWillUnmount() {
    this._unsubscribe();
  }

  render() {
    const setaCidades = async (stateID) => {
      this.setState({ estadoSelecionado: stateID, })

      await api.get(`/state/${stateID}`).then(response => {
        this.setState({
          cidades: response.data.data.state.cities.map(value => ({
            label: value.name,
            value: value.id,
          }))
        });
      });
    }

    const cidades = this.state.cidades.map((value, index) => {
      return (
        <View />
        // <Picker.Item
        //   label={value.name}
        //   value={value.id}
        //   key={value.id}
        // />
      )
    })

    const regioes = (cityID) => {
      if (cityID !== '')
        this.props.navigation.navigate('Região', { cityID });
    }

    return (
      <View style={styles.container}>
        <Text h1>Ecoleta</Text>
        <Text h5 style={{ marginBottom: 20 }}>Seu marketplace de coletas de resíduos.</Text>

        <PickerInput
          label='Escolha um estado'
          itens={this.state.estados}
          onValueChange={setaCidades}
          value={this.state.estadoSelecionado} />

        <PickerInput
          label='Escolha uma cidade'
          itens={this.state.cidades}
          onValueChange={(value) => this.setState({ cidadeSelecionada: value })}
          value={this.state.cidadeSelecionada} />

        <Button
          title=" Buscar "
          type="solid"
          icon={
            <Icon
              name='search'
              size={15}
              color='blue'
            />
          }
          onPress={() => regioes(this.state.cidadeSelecionada)}
        />
      </View>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    paddingTop: 50,
  },
});