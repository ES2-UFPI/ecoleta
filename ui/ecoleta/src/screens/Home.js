import React, { useEffect, useState, Component } from 'react';
import { StyleSheet, View } from 'react-native';
import { Button, Text } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';
import { Picker } from '@react-native-picker/picker';

import api from '../services/api';

export default class Home extends Component {
  state = {
    estados: [],
    cidades: [],
    cidadeSelecionada: ''
  }

  buscaEstados = async () => {
    await api.get(`/states`).then(response => {
      this.setState({
        estados: response.data.data.states
      });
    });
  };

  componentDidMount() {
    this.buscaEstados();
  }

  render() {
    const estados = this.state.estados.map((value, index) => {
      return (
        <Picker.Item
          label={value.name}
          value={value.id}
          key={value.id}
        />
      )
    });

    const setaCidades = async (stateID) => {
      await api.get(`/state/${stateID}`).then(response => {
        this.setState({
          cidades: response.data.data.state.cities
        });
      });
    }

    const cidades = this.state.cidades.map((value, index) => {
      return (
        <Picker.Item
          label={value.name}
          value={value.id}
          key={value.id}
        />
      )
    })

    const regioes = (cityID) => {
      if (cityID !== '')
        this.props.navigation.navigate('Região', { cityID });
    }

    return (
      <View style={styles.container}>
        <Text h1>Ecoleta</Text>
        <Text h5>Seu marketplace de coletas de resíduos.</Text>

        <Text h5>Escolha um estado</Text>
        <Picker
          onValueChange={(value) => setaCidades(value)}
        >
          <Picker.Item
            label='Selecione um estado'
            value=''
            key=''
          />
          {estados}
        </Picker>

        <Text h5>Escolha uma cidade</Text>
        <Picker
          selectedValue={this.state.cidadeSelecionada}
          onValueChange={(value) => this.setState({ cidadeSelecionada: value })}
        >
          <Picker.Item
            label='Selecione uma cidade'
            value=''
            key=''
          />
          {cidades}
        </Picker>

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